<?php 
    session_start();
    $user = NULL;
    require_once 'config/db.php';
    if(isset($_SESSION['user_login']) && !empty($_SESSION['user_login']))
    {
    $user_login = $_SESSION['user_login'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$user_login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
    else{
        header('Location: signin.php');
    }
    // print_r($user);
    // exit();
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

</head>
<header>
    <a href="user.php" class="logo">Register</a>
    <div class="group">
        <ul class="navigation">
            <li><a href="user.php">Home</a></li>
            <li><a href="register.php" > Register</a></li>
            <li><a href="user_information.php" >USER</a></li>
            <li><a href="enrollment_result.php">enrollment Result</a></li>
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
                        <input type="text" name="sid" aria-describedby="sid" value="<?=$user['sid']?>" disabled>
                    </div>
                    <div class="input-box">
                        <span for="email" class="details">Email</span>
                        <input type="text" name="email" aria-describedby="email" value="<?=$user['email']?>"  disabled>
                    </div>
                    <div class="input-box">
                        <span for="firstname" class="details">First name</span>
                        <input type="text" name="firstname" aria-describedby="firstname" value="<?=$user['firstname']?>"  disabled>
                    </div>
                    <div class="input-box">
                        <span for="lastname" class="details">Last name</span>
                        <input type="text" name="lastname" aria-describedby="lastname" value="<?=$user['lastname']?>"  disabled>
                    </div>
                </div>
                <!-- <button type="submit" name="signup" class="button">Sign Up</button> -->
                
                <a  class="button" href="user_update.php?id=<?=$user["id"]?>">Edit</a>
                
                
            </form>
        </div>
    </div>
</body>
</html>
