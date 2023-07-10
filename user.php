<?php 

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['user_login'])) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./css/user.css" rel="stylesheet" >
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
    <div class="header_section">
        <div class="container">
        <?php 

            if (isset($_SESSION['user_login'])) {
                $user_id = $_SESSION['user_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        </div>
    </div>
    <h3 class="content">Welcome, <?php echo $row['sid'].' '. $row['firstname'] . ' ' . $row['lastname'] ?></h3>
    <div>
        <!-- services section start -->
      <div class="services_section layout_padding">
         <div class="container_1">
            <h1 class="services_taital"><span style="color: #fcce2d">About</span> Courses</h1>
            <div class="services_section_2">
               <div class="row">
                  <div class="col-md-6">
                     <div class="image_main">
                        <img src="image/Modern Marketing presentation.jpg" class="image_8" style="width:100%">
                        <div class="text_main">
                           <div class="seemore_text">USER</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="image_main">
                        <img src="image/Modern Marketing presentation (1).jpg" class="image_8" style="width:100%">
                        <div class="text_main">
                           <div class="seemore_text">USER</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="image_main">
                        <img src="image/Modern Marketing presentation (1).jpg" class="image_8" style="width:100%">
                        <div class="text_main">
                           <div class="seemore_text">USER</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="image_main">
                        <img src="image/Modern Marketing presentation.jpg" class="image_8" style="width:100%">
                        <div class="text_main">
                           <div class="seemore_text">USER</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>            
      </div>
      <!-- services section end -->
    </div>
    <!-- Footer -->
    <footer class="Footer">
        <a href="user.php" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">AOM MINT MAI</a></p>
</footer>
</body>
</html>

