<?php
session_start();

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Loop through the $_SESSION['basket'] array
  foreach ($_SESSION['basket'] as $key => $course) {
    // Check if the course's cid matches the id in the URL
    if ($course['course_id'] == $id) {
      // Remove the course from the $_SESSION['basket'] array
      unset($_SESSION['basket'][$key]);
      break;
    }
  }
}

// Redirect back to the original page
header("Location: register.php");
exit;
