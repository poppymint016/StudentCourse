<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sid = $row['sid'];
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/enrollment_result.css" rel="stylesheet">
    </head>
    
    <body>
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
<div class="enroll_result">
    <h2>Enrollment Result</h2>
    <h3><?php echo $row['sid'].' '. $row['firstname'] . ' ' . $row['lastname'] ?></h3>
    <?php
        // Fetch registration information from enroll table based on SID
        $stmt = $conn->prepare("SELECT * FROM enroll WHERE sid = ?");
        $stmt->execute([$sid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Display registration information in a table
        if (count($result) > 0) {
            echo "<table>";
            echo "<tr><th>Course ID</th><th>Course Name</th><th>Section</th><th>Teacher</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["course_id"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td>" . $row["section"] . "</td>";
                echo "<td>" . $row["teacher"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No registration information found for SID: " . $sid;
        }

        // Close database connection
        $conn = null;

    ?>
    </body>
</div>
</html>

