<?php
require_once 'config/db.php';

if(isset($_GET['sid'])) {
    $sid = $_GET['sid'];

    // Delete the student from the enroll table
    $stmt = $conn->prepare("DELETE FROM enroll WHERE sid = :sid");
    $stmt->execute(array(':sid' => $sid));

    header("Location: more_courseid.php?course_id=".$course_id."&section=".$_GET['section']);

} else {
    echo "Student ID not specified.";
}
