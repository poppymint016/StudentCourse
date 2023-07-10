<?php
require_once 'config/db.php';

if(isset($_GET['sec_id'])){
  $sec_id = $_GET['sec_id'];
  $course_id = $_GET['course_id'];
  $section = $_GET['section'];

  $stmt = $conn->prepare("DELETE FROM section WHERE section.sec_id = :sec_id");
  $stmt->execute(array(':sec_id' => $sec_id));

  $stmt = $conn->prepare("DELETE FROM enroll WHERE enroll.course_id = :course_id AND enroll.section = :section");
  $stmt->execute(array(':course_id' => $course_id, ':section' => $section));  

  if ($stmt->rowCount() > 0) {
    header("Location: more_info.php?course_id=".$course_id);
  } else {
    echo "Error: Failed to delete the section.";
    header("Location: more_info.php?course_id=".$course_id);
  }
} else {
  echo "Error: No section id specified.";
}
?>
