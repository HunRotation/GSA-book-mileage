<!--학생 계정으로 로그인하였을 때의 메인 페이지, 자신의 독서 마일리지 열람 가능-->
<?php
if (!isset($_COOKIE['sno']) || $_COOKIE['sno'] == '') {
  header('Location: login.php');
}
if ($_COOKIE['sno'] === 'admin') {
  header('Location: admin.php');
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
$result = mysqli_query($conn, "select * from students where sno=".$_COOKIE['sno']);
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
      <a class="navbar-brand" href="main.php">GSA Book Mileage</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <h4 class="navbar-nav text-center text-white"><?php echo $name; ?>님, 환영합니다</h4>
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
        <div class="col col-4">
          <a class="btn btn-success" href="write_mileage.php" role="button">마일리지 등록</a>
          <a class="btn btn-info" href="book_info.php" role="button">마일리지 도서 목록</a>
          <a class="btn btn-danger" href="logout.php" role="button">로그아웃</a>
        </div>
      </div>
    </div>
    <?php
    $query = "select r.id as id, r.sno as sno, b.title as title,
    b.author as author, r.date as date, r.status as status from read_record r, book_list b
    where r.code=b.code and sno=".$_COOKIE['sno']." order by id DESC";
    $result = mysqli_query($conn, $query);
    ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">번호</th>
          <th scope="col">제목</th>
          <th scope="col">저자</th>
          <th scope="col">입력일</th>
          <th scope="col">상태</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($row = $result->fetch_assoc()) {
            if(!isset($_POST['search']) || empty($_POST['search'])) {
              echo '<tr>';
              echo '<th>'.$row['id'].'</th>';
              echo '<td><a href="view_mileage.php?id='.$row['id'].'" style="text-decoration: none;">'.$row['title'].'</a></td>';
              echo '<td>'.$row['author'].'</td>';
              echo '<td>'.$row['date'].'</td>';
              echo '<td>'.(($row['status'])?('승인됨'):('승인 대기')).'</td>';
              echo '</tr>';
            }
            else if(isset($_POST['search']) && strpos($row['title'], $_POST['search']) !== false) {
              echo '<tr>';
              echo '<th>'.$row['id'].'</th>';
              echo '<td><a href="view_mileage.php?id='.$row['id'].'" style="text-decoration: none;">'.$row['title'].'</a></td>';
              echo '<td>'.$row['author'].'</td>';
              echo '<td>'.$row['date'].'</td>';
              echo '<td>'.(($row['status'])?('승인됨'):('승인 대기')).'</td>';
              echo '</tr>';
            }
          }
        ?>
      </tbody>
    </table>

    <!--Main Navigation-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="template/main_header.js"></script>
  </body>
</html>
