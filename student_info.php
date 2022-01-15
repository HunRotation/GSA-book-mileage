<!--각 학생의 마일리지 관련 정보 확인 가능-->
<?php
if (!isset($_COOKIE['sno']) || $_COOKIE['sno'] != 'admin') {
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
      <a class="navbar-brand" href="main.php">GSA Book Mileage</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>

    </nav>
    <div class="container mt-3 mb-3 w-100 mw-100 p-2 bg-light">
      <div class="row">
        <div class="col col-3">
          <form class="form-inline" style="margin-left: 1em" action="student_info.php" method="post">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="제목 입력" aria-label="Search">
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">검색</button>
          </form>
        </div>
        <div class="col col-4">
          <a class="btn btn-warning" href="main.php" role="button">돌아가기</a>
          <a class="btn btn-danger" href="logout.php" role="button">로그아웃</a>
        </div>
      </div>
    </div>
    <?php
    $query = "select * from students where sno>0";
    $result = mysqli_query($conn, $query);
    ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">학번</th>
          <th scope="col">학년</th>
          <th scope="col">반</th>
          <th scope="col">번호</th>
          <th scope="col">이름</th>
          <th scope="col">물리</th>
          <th scope="col">화학</th>
          <th scope="col">생명과학</th>
          <th scope="col">지구과학</th>
          <th scope="col">정보</th>
          <th scope="col">수학</th>
          <th scope="col">인문사회</th>
          <th scope="col">전체</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($row = $result->fetch_assoc()) {
            $nums = array('P'=>0, 'C'=>0, 'B'=>0, 'E'=>0, 'I'=>0, 'M'=>0, 'H'=>0, 'X'=>0);
            $student_mileage = mysqli_query($conn,
            "select code from read_record where sno=".$row['sno']);
            for($i=0;$i<mysqli_num_rows($student_mileage);$i++) {
                $student_row = $student_mileage->fetch_assoc();
                $key = $student_row['code'][0];
                $nums[$key] += 1;
            }
            if(!isset($_POST['search']) || empty($_POST['search'])) {
                echo '<tr>';
                echo '<td>'.$row['sno'].'</td>';
                echo '<td>'.$row['grade'].'</td>';
                echo '<td>'.$row['class'].'</td>';
                echo '<td>'.$row['num'].'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$nums['P'].'</td>';
                echo '<td>'.$nums['C'].'</td>';
                echo '<td>'.$nums['B'].'</td>';
                echo '<td>'.$nums['E'].'</td>';
                echo '<td>'.$nums['I'].'</td>';
                echo '<td>'.$nums['M'].'</td>';
                echo '<td>'.$nums['H'].'</td>';
                echo '<td>'.array_sum($nums).'</td>';
                echo '</tr>';
            }
            else if(isset($_POST['search']) && strpos($row['name'], $_POST['search']) !== false) {
                echo '<tr>';
                echo '<td>'.$row['sno'].'</td>';
                echo '<td>'.$row['grade'].'</td>';
                echo '<td>'.$row['class'].'</td>';
                echo '<td>'.$row['num'].'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$nums['P'].'</td>';
                echo '<td>'.$nums['C'].'</td>';
                echo '<td>'.$nums['B'].'</td>';
                echo '<td>'.$nums['E'].'</td>';
                echo '<td>'.$nums['I'].'</td>';
                echo '<td>'.$nums['M'].'</td>';
                echo '<td>'.$nums['H'].'</td>';
                echo '<td>'.array_sum($nums).'</td>';
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
