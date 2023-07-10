<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<?php
    require_once 'config/db.php';

    if(isset($_POST['add_course'])){
      $course_id = $_POST['add_courseid'];
      $course_name = $_POST['add_coursename'];
    
      $check_course = $conn->prepare("SELECT * FROM course WHERE course_id = :course_id OR course_name = :course_name");
      $check_course->execute(array(':course_id' => $course_id, ':course_name' => $course_name));
      $result = $check_course->fetchAll();
    
      if(count($result) > 0){
        echo "<script>alert('รหัสรายวิชาหรือชื่อรายวิชานี้มีอยู่ในระบบแล้ว');</script>";
        
      } else {
        $stmt = $conn->prepare("INSERT INTO course (course_id, course_name) VALUES (:course_id, :course_name)");
        $stmt->execute(array(':course_id' => $course_id, ':course_name' => $course_name));
    
        header("Location: admin.php");
      }
    }
?>
    <div class="container">
    <div class="row" style="margin-top: 100px;">
    <div class="col-6">
    <h4 class="text">ADD Course</h4>
		<form class="addcourse" action="addcourse.php" method="POST">
            <div class="addcourse">
                <div class="col-6">
                    <lable>รหัสรายวิชา</lable>
                    <input type="text" name="add_courseid" class="form-control"/>
                </div>
                <div class="col-6">
                    <lable>ชื่อรายวิชา</lable>
                    <input type="text" name="add_coursename" class="form-control"/>
                </div>
                <div class="col-6 mt-3">
                    <button type="submit" name="add_course"  class="btn btn-primary">เพิ่มรายวิชา</button>
                </div>
                
            </div>
        </form>

</div>
</div>
</div>
</body>
</html>