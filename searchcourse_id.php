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
    <link href="./css/searchcourse_id.css" rel="stylesheet" >
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
        <?php 

            if (isset($_SESSION['admin_login'])) {
                $admin_id = $_SESSION['admin_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <h3 class="mt-4">Welcome Admin, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3>
    </div>

    <div class="container" >   
        <h4 class="text">ข้อมูลรายวิชา</h4>
            <table class="table table-hover text-center mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Course ID</th>
                        <th scope="col">Course Name</th>
                        <th scope="col">More Information</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
            <tbody>
            <form action="searchcourse_id.php" method="POST">
                <div class="row">
                    <div class="col-6">
                        <input type="text" placeholder="ค้นหารายวิชา" name="search" class="form-control mt-2"  required>
                        <button type="submit"  class="btn btn-primary mt-2">ค้นหารายวิชา</button>
                        <a href="admin.php" class="btn btn-warning mt-2">ยกเลิก</a>
                    </div>
                </div>    
            <?php 
                if (isset($_POST['search'])){
                    $search=$_POST['search'];
                    $query1="SELECT * FROM course WHERE course_id = :course_id";
                    $statement = $conn->prepare($query1);
                    $statement->execute(array(":course_id"=>$search));
                    $result=$statement->fetchAll(PDO::FETCH_ASSOC);
                    if($result){
                        foreach($result as $row)
                        {
                            ?>
                            <div class="container">   
                                <table class="table table-hover text-center ">
                                    <tr>
                                        <td><?php echo $row["course_id"]; ?></td>
                                        <td><?php echo $row["course_name"]; ?></td>
                                        <td><a href="more_info.php? course_id=<?php echo $row["course_id"]?> "class="btn btn-dark">More</a></td>
                                    <td><a href="delete_course.php?  "class="btn btn-danger">Delete</a></td>
                                    </tr> 
                            <?php
                        }
                     
                    }       
                    else
                    {
                        echo "<script>
                        var result = confirm('รายวิชานี้ไม่อยู่ในระบบ คุณต้องการเพิ่มรายนี้หรือไม่');
                        if (result) {
                            window.location='addcourse.php';
                        }
                        </script>";
                    }
                }         
                
                
            ?>
             </form>   
            </tbody>
        </table>
    </div>
    <footer class="Footer">
      <a href="user.php" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">AOM MINT MAI</a></p>
    </footer>
</body>
</html>
