<!--db의 학생 정보와 입력 정보를 비교하여 옳으면 메인 페이지로 redirect-->
<?php
$db_host = "dev.gsa.hs.kr";
$db_user = "s18004";
$db_password = "1111";
$db_database = "s18004";
$db_port = "18001";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database, $db_port);
mysqli_select_db($conn, $db_database) or die('DB selection failed.');

$sno = $_POST['sno'];
$pw = $_POST['pw'];

$result = mysqli_query($conn, "select * from students where sno=".$sno." && passwd='".$pw."'");


if($result->num_rows == 1) {
  if($sno == '99000') {
      $cookie_name = "sno";
      $cookie_value = "admin";
      setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
      echo "<form name='admin_form' method='post' action='admin.php'>\n";
      echo "<input type='hidden' name='sno' value='".$sno."'>\n";
      echo "</form>";
      echo "<script>document.admin_form.submit()</script>";
  }
  else {
    $cookie_name = "sno";
    $cookie_value = $sno;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    echo "<form name='user_form' method='post' action='main.php'>\n";
    echo "<input type='hidden' name='sno' value='".$sno."'>\n";
    echo "</form>";
    echo "<script>document.user_form.submit()</script>";
  }
}
else {
  echo "<form name='fail_form' method='post' action='login.php'>\n";
  echo "<input type='hidden' name='status' value='failed'>\n";
  echo "</form>";
  echo "<script>document.fail_form.submit()</script>";
}

?>
