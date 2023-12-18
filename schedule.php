<?php
  require_once './config.php';
  if( isset( $_SESSION["staff"] )) header("location: ./staff.php");
  if( isset( $_SESSION["student"] ) == false) header("location: ./login.php");

  $delete_requests = $db->query("SELECT course.*, course_remove_request.status FROM course_remove_request INNER JOIN course on course.id=course_remove_request.course_id WHERE student_id=$_SESSION[student]")->fetchAll();
  $sessions = $db->query( "SELECT session.*, course.name as course FROM session
  INNER JOIN student_course ON student_course.course_id=session.course_id
  INNER JOIN course on course.id=student_course.course_id WHERE student_course.student_id=$_SESSION[student]" )->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <!-- cdn -->
  <!-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
      integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N"
      crossorigin="anonymous"
    /> -->
  <!-- local -->
  <link rel="stylesheet" href="./src/css/bootstrap.rtl.min.css" />
  <link rel="stylesheet" href="./src/css/common.css" />
  <link href="./src/datatables.min.css" rel="stylesheet">

  <title>الطالب</title>
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg bg-light rounded shadow mb-5" aria-label="Twelfth navbar example">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./schedule.php">الجدول وطلبات الحذف</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./student.php">الكورسات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./logout.php">تسجيل الخروج</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
 


  <div class="container border shadow rounded pt-3 pb-4 mt-5">
    <div class="row mt-4 px-2">
    <h1 class="leading-4 text-center">الجدول</h1>
    <hr class="mx-auto mb-3" />
    <ul class="list-group">
          <li class="list-group-item">الأحد:
            <?php foreach ($sessions as $session ) {
              if( $session["day"] == 1 ){?>
                <p><?= $session["course"] ?>: <?= $session["time"] ?></p>
            <?php }} ?>
          </li>
          <li class="list-group-item">الأثنين:
            <?php foreach ($sessions as $session ) {
              if( $session["day"] == 2 ){?>
                <p><?= $session["course"] ?>: <?= $session["time"] ?></p>
            <?php }} ?>
          </li>
          <li class="list-group-item">الثلاثاء:
            <?php foreach ($sessions as $session ) {
              if( $session["day"] == 3 ){?>
                <p><?= $session["course"] ?>: <?= $session["time"] ?></p>
            <?php }} ?>
          </li>
          <li class="list-group-item">الأربعاء:
            <?php foreach ($sessions as $session ) {
              if( $session["day"] == 4 ){?>
                <p><?= $session["course"] ?>: <?= $session["time"] ?></p>
            <?php }} ?>
          </li>
          <li class="list-group-item">الخميس:
            <?php foreach ($sessions as $session ) {
              if( $session["day"] == 5 ){?>
                <p><?= $session["course"] ?>: <?= $session["time"] ?></p>
            <?php }} ?>
          </li>

        </ul>
  </div>
  </div>
  <div class="container border shadow rounded pt-3 pb-4 mt-5">
    <?php if ($msg != "") { ?>
      <div class="text-center alert alert-dismissible alert-danger row mx-auto">
        <strong><?= $msg ?></strong>
      </div>
    <?php } ?>
    <div class="row mt-4 px-2">
    <h1 class="leading-4 text-center">طلبات الحذف</h1>
    <hr class="mx-auto mb-3" />
    <table id="students" class="table table-dark">
      <thead>
        <tr>
          <th>Course Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($delete_requests as $course) { ?>
          <tr>
            <td><?= $course["name"] ?></td>
            <td>
              <?php if( $course["status"] == 0 ){?>
                <p class="text-warning">في الإنتظار</p>

                <?php }else{?>
                  <p class="text-danger">مرفوض</p>
                <?php }?>
            </td>
            
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  </div>
  </div>



  <!-- Scripts -->
  <!-- Bootstrap Bundle  -->
  <!-- cdn -->
  <!-- <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script> -->
  <!-- local -->
  <script src="./src/js/jquery.dataTables.min.js"></script>
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/datatables.min.js"></script>
  <script src="./src/js/main.js"></script>
  <script>
    // new DataTable('#students');
  </script>
</body>

</html>