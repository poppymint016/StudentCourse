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
            <th scope="col">Student ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Option</th>
          </tr>
      </thead>
      <h1>Enroll Information</h1>
      <?php
        require_once 'config/db.php';

        if(isset($_GET['course_id'])){
        $course_id = $_GET['course_id'];

        $stmt = $conn->prepare("SELECT enroll.sid, users.firstname, users.lastname FROM enroll INNER JOIN users ON enroll.sid = users.sid WHERE enroll.course_id = :course_id AND enroll.section = :section");
        $stmt->execute(array(':course_id' => $course_id, ':section' => $_GET['section']));
        $result = $stmt->fetchAll();

        if(count($result) > 0){
            foreach($result as $row){
            echo "<tr>";
            echo "<td>" . $row['sid'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td><a href='delete_student2.php?sid=". $row['sid'] . "' onclick='return confirm(\"Are you sure you want to delete this section?\");'>Delete</a></td>";
            echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No enrolled students found for this section.";
        }
        } else {
        echo "No course id specified.";
        }
        ?>

  </table>
</div>
</body>
</html>
