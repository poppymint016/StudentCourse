<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section</title>
    <link href="./css/admin.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<header>
        <a href="admin.php" class="logo">ADMIN</a>
        <div class="group">
            <ul class="navigation">
                <li><a href="admin_student.php">Student</a></li>
                <li><a href="admin.php" > Course</a></li>
                <li><a href="addcourse.php" >Add Course</a></li>
                <li><a href="logout.php" ><i class="fa fa-lock"></i> LOGOUT</a></li>
            </ul>
        </div>
</header>
<body>

<div>
  <?php
    require_once 'config/db.php';

    if(isset($_GET['course_id'])){
      $course_id = $_GET['course_id'];
    
      if(isset($_POST['submit'])){
        $section = $_POST['section'];
        $teacher = $_POST['teacher'];
    
        $check_section = $conn->prepare("SELECT * FROM section WHERE course_id = :course_id AND section = :section");
        $check_section->execute(array(':course_id' => $course_id, ':section' => $section));
        $result = $check_section->fetchAll();
    
        if(count($result) > 0){
          echo "<script>alert('Sectionนี้มีอยู่ในระบบแล้ว กรุณากรอกใหม่');</script>";
        } else {
          $stmt = $conn->prepare("INSERT INTO section (course_id, section, teacher) VALUES (:course_id, :section, :teacher)");
          $stmt->execute(array(':course_id' => $course_id, ':section' => $section, ':teacher' => $teacher));
    
          header("Location: more_info.php?course_id=$course_id");
        }
      }
    
  ?>
  <div class="container">
    <div class="row" style="margin-top: 100px;">
    <h4 class="text">Add Section</h4>
    <div class="col-6">
  <form action="" method="post">
    <div class="col-6">
      <label for="section">Section:</label>
      <input type="text" name="section" id="section"class="form-control">
    </div>
    <div class="col-6">
      <label for="teacher">Teacher:</label>
      <input type="text" name="teacher" id="teacher"class="form-control">
      </div>
    <div class="col-6 mt-3" >
      <input type="submit" name="submit" value="Submit"class="btn btn-primary">
    </div>
  </form>
  <?php
    } else {
      echo "No course id specified.";
    }
  ?>
  </div></div></div>
</div>

</body>
</html>
