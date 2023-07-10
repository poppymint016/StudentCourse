<?php 
    session_start();
    require_once 'config/db.php'; 
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($_POST['submit'])) {

            $sid = $_POST['sid'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
        
            $check_query = "SELECT * FROM users WHERE sid = :sid AND id != :id";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bindParam(':sid', $sid);
            $check_stmt->bindParam(':id', $id);
            $check_stmt->execute();

            if ($check_stmt->rowCount() > 0) {
                echo "<script>alert('student ID นี้มีอยู่ในระบบแล้ว กรุณากรอกใหม่อีกครั้ง');</script>";
            } else {
                $sql = "UPDATE users SET id=:id, sid=:sid, firstname=:firstname, lastname=:lastname, email=:email WHERE id=:id";
                $update_stmt = $conn->prepare($sql);
                $update_stmt->bindParam(':id', $id);
                $update_stmt->bindParam(':sid', $sid);
                $update_stmt->bindParam(':firstname', $firstname);
                $update_stmt->bindParam(':lastname', $lastname);
                $update_stmt->bindParam(':email', $email);
                $update_result = $update_stmt->execute();

                if ($update_result) {
                    header('location:user_information.php');
                } else {
                    echo "Error updating data";
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./css/signup.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="title">Update Information</div>
        <div class="content">
            <form method="post">
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
                        <input type="text" name="sid" aria-describedby="sid" value="<?=$row['sid']?>"><br>
                    </div>
                    <div class="input-box">
                        <span for="email" class="details">Email</span>
                        <input type="text" name="email" aria-describedby="email" value="<?=$row['email']?>"><br>
                    </div>
                    <div class="input-box">
                        <span for="firstname" class="details">First name</span>
                        <input type="text" name="firstname" aria-describedby="firstname" value="<?=$row['firstname']?>"><br>
                    </div>
                    <div class="input-box">
                        <span for="lastname" class="details">Last name</span>
                        <input type="text" name="lastname" aria-describedby="lastname" value="<?=$row['lastname']?>"><br>
                    </div>
                </div>
                <!-- <button type="submit" name="signup" class="button">Sign Up</button> -->
                
                    <input class="btn btn-primary" type="submit" name="submit" value="UPDATE">
                
            </form>
        </div>
    </div>
</body>
</html>