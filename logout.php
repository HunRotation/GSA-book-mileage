<!--쿠키에 저장된 로그인 세션 해제-->
<?php
setcookie("sno", "", time()-3600);
header("Location: login.php");
?>
