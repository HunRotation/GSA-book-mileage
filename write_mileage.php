<!--마일리지 양식을 입력하는 웹페이지-->

<?php
if (!isset($_COOKIE['sno']) || $_COOKIE['sno'] == '') {
  header('Location: login.php');
}
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db_host = "dev.gsa.hs.kr";
$db_user = "s18004";
$db_password = "1111";
$db_database = "s18004";
$db_port = "18001";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database, $db_port);
mysqli_select_db($conn, $db_database) or die('DB selection failed.');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="login.css">
    <title>GSA 독서마일리지</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
      <a class="navbar-brand" href="#">GSA Book Mileage</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </nav>
    <div class="container mt-3 mb-3 w-100 mw-100 p-2 bg-light">
      <div class="row">
        <div class="col col-3">
          <form class="form-inline" style="margin-left: 1em" action="main.php" method="post">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="제목 입력" aria-label="Search">
            <input type="hidden" name="sno" value="<?php echo $_COOKIE['sno'];?>">
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">검색</button>
          </form>
        </div>
        <div class="col col-5">
          <a class="btn btn-success" href="write_mileage.php" role="button">마일리지 등록</a>
          <?php if(isset($_COOKIE['sno']) && $_COOKIE['sno'] != 'admin')  {echo '<a class="btn btn-info" href="book_info.php" role="button">마일리지 도서 목록</a>';}?>
		  <a class="btn btn-warning" href="main.php" role="button">돌아가기</a>
          <a class="btn btn-danger" href="logout.php" role="button">로그아웃</a>
        </div>
      </div>
    </div>
    <?php
    $query = "select * from book_list where code not like 'X%' order by code ASC";
    $result = mysqli_query($conn, $query);
    ?>

  <?php
    if(isset($_POST['id'])) {
      $editquery = "select
      b.title as title, b.author as author, b.publisher as publisher
      from read_record r, book_list b where r.code=b.code and id=".$_POST['id'];
      $editresult = mysqli_query($conn, $editquery);
      $editrow = $editresult->fetch_assoc();
    }
  ?>
  <form action="insert_mileage.php" method="post">
    <div class="form-group p-5 bg-light">
      <label for="BookSelect">학생명</label>
      <?php
      $getname = '';
      if (isset($_COOKIE['sno']) && $_COOKIE['sno'] != 'admin') {
        $resname = mysqli_query($conn, 'select name from students where sno='.$_COOKIE['sno']);
        $getname = ($resname->fetch_assoc())['name'];
      }
        ?>
      <input type="text" class="form-control" id="student_name_input" name="stuname" value="<?=$getname?>" placeholder="이름 입력" <?php if(isset($_COOKIE['sno']) && $_COOKIE['sno'] != 'admin') {echo 'readonly';} ?>>
      <label for="BookSelect">책 선택</label>
      <select id="bookname_select" class="form-control" name="bookname" id="BookSelect">
        <option value="0">직접입력</option>
        <?php
        while($row = $result->fetch_assoc()) {
          echo '<option value="'.$row['code'].'">'.$row['title'].'</option>';
        }
        ?>
      </select>
    </div>
    <div class="form-group p-5 bg-light">
      <label for="book_title_input">제목</label>
      <input type="text" class="form-control" id="book_title_input" name="booktitle" value="<?php if (isset($_POST['id'])) {echo $editrow['title'];}?>"
      placeholder="제목">
      <label for="book_author_input">저자</label>
      <input type="text" class="form-control" id="book_author_input" name="bookauthor" value="<?php if (isset($_POST['id'])) {echo $editrow['author'];}?>"
      placeholder="저자">
      <label for="book_publisher_input">출판사</label>
      <input type="text" class="form-control" id="book_publisher_input" name="bookpublisher" value="<?php if (isset($_POST['id'])) {echo $editrow['publisher'];}?>"
      placeholder="출판사">
      <script>
        document.onselectionchange = onBookNameChange;
        var e = document.getElementById("bookname_select");
        function onBookNameChange() {
          var book_name = e.options[e.selectedIndex].value;
          if (book_name == "0") {
            document.getElementById("book_title_input").readOnly = false;
            document.getElementById("book_author_input").readOnly = false;
            document.getElementById("book_publisher_input").readOnly = false;
          }
          else {
            document.getElementById("book_title_input").readOnly = true;
            document.getElementById("book_author_input").readOnly = true;
            document.getElementById("book_publisher_input").readOnly = true;
            document.getElementById("book_title_input").value = "";
            document.getElementById("book_author_input").value = "";
            document.getElementById("book_publisher_input").value = "";
          }
        }
      </script>
    </div>
    <div class="form-group m-5">
      <input type="hidden" name="originalID" value="<?php if (isset($_POST['id'])) {echo $_POST['id'];} else {echo 0;}?>">
      <button type="submit" class="btn btn-primary">제출</button>
    </div>
  </form>

    <!--Main Navigation-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="template/main_header.js"></script>
  </body>
</html>
