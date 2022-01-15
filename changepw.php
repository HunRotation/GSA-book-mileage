<!--비밀번호 변경 페이지-->
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
  <body>
    <div class="login-form">
        <form action="update_process.php" method="post">
            <h2 class="text-center">비밀번호 변경</h2>
            <div class="form-group">
                <label for="sno_input">학번</label>
                <input type="text" class="form-control" id="sno_input" name="sno" placeholder="학번" required="required">
            </div>
            <div class="form-group">
                <label for="name_input">이름</label>
                <input type="text" class="form-control" id="name_input" name="name" placeholder="이름" required="required">
            </div>
            <div class="form-group">
                <label for="current_pw_input">현재 비밀번호</label>
                <input type="password" class="form-control" id="current_pw_input" name="current_pw" placeholder="현재 비밀번호" required="required">
            </div>
            <div class="form-group">
                <label for="new_pw_input">새 비밀번호</label>
                <input type="password" class="form-control" id="new_pw_input" name="new_pw" placeholder="새 비밀번호" required="required">
            </div>
            <div class="form-group">
                <label for="confirm_pw_input">비밀번호 확인</label>
                <input type="password" class="form-control" id="confirm_pw_input" name="confirm_pw" placeholder="비밀번호 확인" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">비밀번호 변경</button>
            </div>
            <div class="clearfix">
                <a href="login.php" class="pull-right">로그인</a>
            </div>
            <?php
              if($_POST['status'] == "failed") {
                echo '
                <div class="alert alert-danger" style="margin-top: 0.5em;">
                  학생 정보가 잘못되었습니다.<br>다시 시도해 주세요.
                </div>
                ';
              }
              else if($_POST['status'] == "pw_not_confirmed") {
                echo '
                <div class="alert alert-danger" style="margin-top: 0.5em;">
                  새 비밀번호가 일치하지 않습니다.<br>다시 시도해 주세요.
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
  </body>
</html>
