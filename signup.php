<?php 

    session_start();
    require_once 'config/db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./css/signup.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="title">Registration</div>
        <div class="content">
            <form action="signup_db.php" method="post">
                <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['warning'])) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php 
                            echo $_SESSION['warning'];
                            unset($_SESSION['warning']);
                        ?>
                    </div>
                <?php } ?>
                <div class="user-details">
                    <div class="input-box">
                        <span for="sid" class="details">Student ID</span>
                        <input type="text" name="sid" aria-describedby="sid" placeholder="Enter your student id" required >
                    </div>
                    <div class="input-box">
                        <span for="email" class="details">Email</span>
                        <input type="text" name="email" aria-describedby="email" placeholder="Enter your Email" required>
                    </div>
                    <div class="input-box">
                        <span for="firstname" class="details">First name</span>
                        <input type="text" name="firstname" aria-describedby="firstname" placeholder="Enter your First name" required>
                    </div>
                    <div class="input-box">
                        <span for="lastname" class="details">Last name</span>
                        <input type="text" name="lastname" aria-describedby="lastname" placeholder="Enter your Last name" required>
                    </div>
                    <div class="input-box">
                        <span for="password" class="details">Password</span>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-box">
                        <span for="confirm password" class="details">Confirm Password</span>
                        <input type="password" name="c_password" placeholder="Confirm your password" required>
                    </div>
                </div>
                <!-- <button type="submit" name="signup" class="button">Sign Up</button> -->
                <div class="button">
                    <input type="submit" name="signup" value="Register">
                </div>
            </form>

            <div class="signup">
            <p>Already a member? Click here for <a href="signin.php">singin</a></p>
            </div>
        </div>
    </div>
</body>
</html>