<?php
  // PHP Code
  require_once 'config/db.php';

  if(isset($_GET['id']) && isset($_GET['sid'])) {
    $id = $_GET['id'];
    $sid = $_GET['sid'];
  
    try {
      $stmt = $conn->prepare("DELETE FROM enroll WHERE id = :id");
      $stmt->execute(array(':id' => $id));
      header("Location: more_enroll.php?sid=$sid");
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
?>
