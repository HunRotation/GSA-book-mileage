<!--학생의 마일리지 상세 열람 페이지: 책에 대한 정보와 학생 그 자신이 쓴 내용을 볼 수 있음-->
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

$query = "select sno from read_record where id=".$_GET['id'];
$result = mysqli_query($conn, $query);
$sno = $result->fetch_assoc()['sno'];
$result = mysqli_query($conn, "select * from students where sno=".$sno);
$name = ($result->fetch_assoc())['name'];
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
      <div class="collapse navbar-collapse" id="navbarNav">
        <h4 class="navbar-nav text-center text-white"><?php echo $name; ?>님, 환영합니다</h3>
      </div>

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
          <a class="btn btn-warning" href="student_info.php" role="button">학생 목록</a>
          <a class="btn btn-info" href="book_info.php" role="button">마일리지 도서 목록</a>
          <a class="btn btn-danger" href="logout.php" role="button">로그아웃</a>
        </div>
      </div>
    </div>
    <?php
    $query = "select r.id as id, r.sno as sno, b.subject as subject, b.title as title,
    b.author as author, b.publisher as publisher, r.date as date from read_record r, book_list b
    where r.code=b.code and r.sno=".$sno." and r.id=".$_GET['id'];
    $result = mysqli_query($conn, $query);
    $row = $result->fetch_assoc();
	  $query2 = "select name from students where sno=".$row['sno'];
	  $result_name = mysqli_query($conn, $query2);
	  $name = $result_name->fetch_assoc()['name'];
    ?>


<div class="container w-100 mx-2">
  <div class="row">
	<div class="col col-6">
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col" >학번</th>
	  <th scope="col" ><?php echo $row['sno'];?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
	  <th scope="row" >이름</th>
      <td ><?php echo $name;?></td>
    </tr>
	<tr>
	  <th scope="row" >분야</th>
      <td ><?php echo $row['subject'];?></td>
    </tr>
	<tr>
      <th scope="row" >책 제목</th>
      <td ><?php echo $row['title'];?></td>
    </tr>
	<tr>
      <th scope="row" >저자</th>
      <td ><?php echo $row['author'];?></td>
    </tr>
	<tr>
	  <th scope="row" >출판사</th>
      <td ><?php echo $row['publisher'];?></td>
    </tr>
	<tr>
	  <th scope="row" >입력일</th>
      <td ><?php echo $row['date'];?></td>
    </tr>
  </tbody>
</table>
	</div>
  </div>
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
