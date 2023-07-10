<?php 

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
    }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
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
<div class="container">
<form action="searchcourse_id.php" method="POST">
  <div class="row" style="margin-top: 50px;">
    <div class="col-6">
      <input type="text" placeholder="ค้นหารายวิชา" name="search" class="form-control mt-5"  required>
      <button type="submit" class="btn btn-primary mt-3">ค้นหารายวิชา</button>
      <a href="admin.php" class="btn btn-warning mt-3">ยกเลิก</a>
    </div>
  </div>
</div>
</form>  
    <div class="container">   
      <table class="table table-hover text-center mt-3">
        <thead class="table-dark">
          <tr>
            <th scope="col">Course ID</th>
            <th scope="col">Course Name</th>
            <th scope="col">More Information</th>
            <th scope="col">Option</th>
          </tr>
        </thead>
      <?php
        // PHP Code
        require_once 'config/db.php';

        try {
          $stmt = $conn->prepare("SELECT course_id, course_name FROM course");
          $stmt->execute();
          $result = $stmt->fetchAll();
          
          if(count($result) > 0){
            foreach($result as $row){
              echo "<tr>";
              echo "<td>" . $row['course_id'] . "</td>";
              echo "<td>" . $row['course_name'] . "</td>";
              echo "<td><a href='more_info.php?course_id=" . $row['course_id'] . "' class='btn btn-dark'>More Info</a></td>";
              echo "<td><a href='delete_course.php?course_id=" . $row['course_id'] . "'onclick='return confirm(\"Are you sure you want to delete this User?\"); class='btn btn-danger'>Delete</a></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No courses found</td></tr>";
          }
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
      ?>
      </table>
            </tbody>
        </table>
    </div>
    <footer class="Footer">
      <a href="user.php" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">AOM MINT MAI</a></p>
    </footer>   
</body>
</html>