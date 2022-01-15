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

mysqli_query($conn, "delete from read_record where id=".$_POST['id']);

header("Location: main.php");
?>
