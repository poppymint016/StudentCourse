<?php
require_once 'config/db.php';
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
  
    $conn->beginTransaction();
  
    $stmt = $conn->prepare("DELETE FROM section WHERE course_id = :course_id");
    $stmt->execute(array(':course_id' => $course_id));
  
    $stmt = $conn->prepare("DELETE FROM course WHERE course_id = :course_id");
    $stmt->execute(array(':course_id' => $course_id));
  
    $stmt = $conn->prepare("DELETE FROM enroll WHERE course_id = :course_id");
    $stmt->execute(array(':course_id' => $course_id));

    if ($stmt->rowCount() > 0) {
      $conn->commit();
      header("Location: admin.php");
    } else {
      $conn->rollBack();
      echo "Failed to delete data.";
    }
  } else {
    echo "No course id specified.";
  }
  
?>