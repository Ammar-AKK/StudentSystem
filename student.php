<?php
  require_once './config.php';
  $date = date("Y-m-d", time());
  if( isset( $_SESSION["staff"] )) header("location: ./staff.php");
  if( isset( $_SESSION["student"] ) == false) header("location: ./login.php");

  if( isset( $p["remove_course"] ) ){

    $course_started = $db->query("SELECT course.id FROM student_course INNER JOIN course ON course.id=student_course.course_id WHERE course.`starting_timestamp` <= '$date' AND student_course.course_id=$p[remove_course] AND student_course.student_id=$_SESSION[student]")->rowCount()>0;
    if( $course_started ){
      // request course removal
      $db->query("INSERT IGNORE INTO  course_remove_request ( course_id, student_id ) VALUES ($p[remove_course], $_SESSION[student])");
    }else{
      // delete course
      $db->query("DELETE FROM student_course WHERE course_id=$p[remove_course] AND student_id=$_SESSION[student]");
    }
  }
  if( isset( $p["course"] ) ) $db->query("INSERT IGNORE INTO student_course( student_id, course_id ) VALUES( $_SESSION[student], $p[course] )");
  $courses = $db->query("SELECT * FROM course WHERE `starting_timestamp` > '$date'")->fetchAll();
  $my_courses = $db->query("SELECT course.* FROM student_course INNER JOIN course ON course.id=student_course.course_id WHERE student_id = $_SESSION[student]")->fetchAll();

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
  <div class="container border shadow rounded pt-3 pb-4">
    <?php if ($msg != "") { ?>
      <div class="text-center alert alert-dismissible alert-danger row mx-auto">
        <strong><?= $msg ?></strong>
      </div>
    <?php } ?>
    <h1 class="leading-4 text-center">اضافة كورس جديد</h1>
    <hr class="mx-auto mb-3" />
    <form class="row" method="post">
      <!-- Name -->
      <div class="col-12 my-2">
        <label for="City" class="form-label">الكورس</label>
        <select name="course" id="" class="form-select">
          <?php foreach ($courses as $course ) {?>
            <option value="<?= $course["id"] ?>"><?= $course["name"] ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-12 mt-4">
        <button class="btn btn-dark w-100" type="submit">اضافة</button>
      </div>
    </form>

    </div>

  <div class="container border shadow rounded pt-3 pb-4 mt-5">
    <?php if ($msg != "") { ?>
      <div class="text-center alert alert-dismissible alert-danger row mx-auto">
        <strong><?= $msg ?></strong>
      </div>
    <?php } ?>
    <div class="row mt-4 px-2">
    <h1 class="leading-4 text-center">الكورسات</h1>
    <hr class="mx-auto mb-3" />
    <table id="students" class="table table-dark">
      <thead>
        <tr>
          <th>Course Name</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($my_courses as $course) { ?>
          <tr>
            <td><?= $course["name"] ?></td>
            <td>
              <form method="post">
                <input type="hidden" value="<?= $course["id"] ?>" name="remove_course" class="btn btn-danger">
                <input type="submit" value="حذف" class="btn btn-danger">
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
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