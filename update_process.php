<!--특정 학생에 대해 입력된 정보를 db와 비교하고, 모든 정보가 맞으면 비밀번호 update-->
<?php
$db_host = "dev.gsa.hs.kr";
$db_user = "s18004";
$db_password = "1111";
$db_database = "s18004";
$db_port = "18001";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database, $db_port);
mysqli_select_db($conn, $db_database) or die('DB selection failed.');

$sno = $_POST['sno'];
$name = $_POST['name'];
$current_pw = $_POST['current_pw'];
$new_pw = $_POST['new_pw'];
$confirm_pw = $_POST['confirm_pw'];

$result = mysqli_query($conn, "select * from students where sno=".$sno." && passwd='".$current_pw."' && name='".$name."'");

if($new_pw != $confirm_pw) {
  echo "<form name='fail_form' method='post' action='changepw.php'>\n";
  echo "<input type='hidden' name='status' value='pw_not_confirmed'>\n";
  echo "</form>";
  echo "<script>document.fail_form.submit()</script>";
}
else if($result->num_rows == 1) {
  echo "<form name='success_form' method='post' action='login.php'>\n";
  echo "<input type='hidden' name='status' value='succeeded'>\n";
  echo "</form>";
  echo "<script>document.success_form.submit()</script>";

  $result = mysqli_query($conn, "update students set passwd='".$new_pw."'where sno=".$sno." && passwd='".$current_pw."' && name='".$name."'");
}
else {
  echo "<form name='fail_form' method='post' action='changepw.php'>\n";
  echo "<input type='hidden' name='status' value='failed'>\n";
  echo "</form>";
  echo "<script>document.fail_form.submit()</script>";
}
?>
