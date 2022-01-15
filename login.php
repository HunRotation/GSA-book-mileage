<!--가장 처음에 나오는 로그인 화면: 로그인 세션 만료 시 모든 페이지에서, 또는 운영자 세션이 아닐 때 운영자 전용 페이지에서 여기로 redirect-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="login.css">
    <title>GSA 독서마일리지</title>
  </head>
  <body oncopy="return false" oncut="return false" onpaste="return false">
    <div class="login-form">
        <form action="confirmation.php" method="post">
            <h2 class="text-center">로그인</h2>
            <div class="form-group">
                <input type="text" class="form-control" name="sno" placeholder="학번" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pw" placeholder="비밀번호" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">로그인</button>
            </div>
            <div class="clearfix">
                <a href="changepw.php" class="pull-right">비밀번호 변경</a>
            </div>
            <?php
              if($_POST['status'] == "failed") {
                echo '
                <div class="alert alert-danger" style="margin-top: 0.5em;">
                  잘못된 비밀번호입니다.<br>다시 시도해 주세요.
                </div>
                ';
              }
              if($_POST['status'] == "succeeded") {
                echo '
                <div class="alert alert-success" style="margin-top: 0.5em;">
                  비밀번호가 성공적으로 변경되었습니다.
                </div>
                ';
              }
            ?>
        </form>
    </div>
    <!--Main Navigation-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="template/main_header.js"></script>
    <script type="text/javascript" src="cookie.js"></script>
  </body>
</html>
