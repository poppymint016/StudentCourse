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
<div class="container" style="margin-top: 100px;">   
    <table class="table table-hover text-center mt-3">
      <thead class="table-dark">
        <tr>
          <th scope="col">Course ID</th>
          <th scope="col">Course Name</th>
          <th scope="col">Section</th>
          <th scope="col">Teacher</th>
          <th scope="col">Option</th>
        </tr>
      </thead>
<?php
  // PHP Code
  require_once 'config/db.php';

  $sid = $_GET['sid'];

  try {
    $stmt = $conn->prepare("SELECT enroll.id, enroll.sid, enroll.course_id, course.course_name, enroll.section, enroll.teacher FROM enroll JOIN course ON enroll.course_id = course.course_id WHERE enroll.sid = :student_id");
    $stmt->execute(array(':student_id' => $sid));
    $result = $stmt->fetchAll();
    
    if(count($result) > 0){
      foreach($result as $row){
        echo "<tr>";
        echo "<td>" . $row['course_id'] . "</td>";
        echo "<td>" . $row['course_name'] . "</td>";
        echo "<td>" . $row['section'] . "</td>";
        echo "<td>" . $row['teacher'] . "</td>";
        echo "<td><a href='delete_enroll.php?id=". $row['id'] . "&sid=" . $sid . "' onclick='return confirm(\"Are you sure you want to delete this section?\");'>Delete</a></td>";
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='4'>No courses enrolled</td></tr>";
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
?>
 </table> 
  </div>
</body>
</html>