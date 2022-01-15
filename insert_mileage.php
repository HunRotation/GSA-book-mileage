<!--write_mileage.php에서 쓴 내용을 db에 올림-->
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db_host = "dev.gsa.hs.kr";
$db_user = "s18004";
$db_password = "1111";
$db_database = "s18004";
$db_port = "18001";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database, $db_port);
mysqli_select_db($conn, $db_database) or die('DB selection failed.');

var_dump($_POST['stuname']);
var_dump($_POST['booktitle']);
var_dump($_POST['bookauthor']);
var_dump($_POST['bookpublisher']);

$getname = mysqli_query($conn, "select sno from students where name='".$_POST['stuname']."'");
if ((!$_POST['stuname']) || mysqli_num_rows($getname)==0) {
  echo '<script type="text/JavaScript">alert("이름을 정확히 입력해 주세요.");</script>';
  var_dump($_POST);

  //header("Location: write_mileage.php");
}
else if ($_POST['bookname'] == '0' && !($_POST['booktitle']&&$_POST['bookauthor']&&$_POST['bookpublisher'])) {
  echo '<script type="text/JavaScript">alert("책의 정보를 빈칸 없이 입력해 주세요.");</script>';
  header("Location: write_mileage.php");
}
else {
  $sno = $getname->fetch_assoc()['sno'];
  if($_POST['bookname'] != '0') {
      $code = $_POST['bookname'];
      $check = mysqli_num_rows(mysqli_query($conn, "select * from read_record where sno=".$sno." and code='".$code."'"));
      var_dump($sno);
      var_dump($code);
      if ($check == 0) {
        $add = mysqli_query($conn, "insert into read_record (code, sno) values ('".$code."',".$sno.")");
      }
      else {
        header("Location: write_mileage.php");
      }
  }
  else {
      $bookcheck = mysqli_query($conn, "select code from book_list where
      title='".$_POST['booktitle']."' and author='".$_POST['bookauthor']."' and publisher='".$_POST['bookpublisher']."'");
      if (mysqli_num_rows($bookcheck) == 0) {
        $rownum = mysqli_num_rows(mysqli_query($conn, "select * from book_list where code like 'X%'"));
        $addbook = mysqli_query($conn, "insert into book_list values
        ('X".($rownum+1)."', '".$_POST['booktitle']."', '".$_POST['bookauthor']."', '".$_POST['bookpublisher']."', '기타')");
        $code = 'X'.($rownum+1);
      }
      else {
        $code = ($bookcheck->fetch_assoc())['code'];
      }
      $check = mysqli_num_rows(mysqli_query($conn, "select * from read_record where sno=".$sno." and code='".$code."'"));
      var_dump($check);
      if ($check == 0) {
        $add = mysqli_query($conn, "insert into read_record (code, sno) values ('".$code."',".$sno.")");
      }
      else {
        header("Location: write_mileage.php");
      }
  }

  header("Location: main.php");
}


?>
