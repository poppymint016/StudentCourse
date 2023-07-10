<?php 

session_start();
require_once 'config/db.php';

if (!isset($_SESSION['admin_login'])) {
  $_SESSION['error'] = 'Please login to access this page!';
  header('location: signin.php');
}

if(isset($_GET['sid'])) {
  $student_id = $_GET['sid'];
  
  try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE sid = :student_id");
    $stmt->execute(array(':student_id' => $student_id));
    $result = $stmt->fetch();
    
    if(count($result) > 0){
      $student_id = $result['sid'];
      $first_name = $result['firstname'];
      $last_name = $result['lastname'];
      $email = $result['email'];

    } else {
      echo "No student information found";
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user information</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <link rel="stylesheet" href="./css/user_information.css">
    <link href="./css/admin.css" rel="stylesheet" >
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
        <div class="title">Profile Information</div>
        <div class="content">
            <form action="user_update.php" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span for="sid" class="details">Student ID</span>
                        <input type="text" name="sid" aria-describedby="sid" value="<?=$result['sid']?>" disabled>
                    </div>
                    <div class="input-box">
                        <span for="email" class="details">Email</span>
                        <input type="text" name="email" aria-describedby="email" value="<?=$result['email']?>"  disabled>
                    </div>
                    <div class="input-box">
                        <span for="firstname" class="details">First name</span>
                        <input type="text" name="firstname" aria-describedby="firstname" value="<?=$result['firstname']?>"  disabled>
                    </div>
                    <div class="input-box">
                        <span for="lastname" class="details">Last name</span>
                        <input type="text" name="lastname" aria-describedby="lastname" value="<?=$result['lastname']?>"  disabled>
                    </div>
                </div>
                <!-- <button type="submit" name="signup" class="button">Sign Up</button> -->
                
                <a  class="button" href="user_update.php?id=<?=$result["id"]?>">Edit</a>
                
                
            </form>
        </div>
    </div>
</body>
</html>


