<?php
session_start();
require_once 'config/db.php';

$courses = array();
$cart = array();

// Retrieve the list of courses from the database
$stmt = $conn->prepare("SELECT * FROM course
						JOIN section ON course.course_id = section.course_id;");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Search for courses if the search term is provided
if (isset($_POST['search'])) {
	$search_term = $_POST['search_term'];
	$search_results = array();
	foreach ($courses as $course) {
	  if (strpos(strtolower($course['course_id']), strtolower($search_term)) !== false) {
		$search_results[] = $course;
	  }
	}
}

// Add a course to the basket if the add button is clicked
if (isset($_POST['add'])) {
  $course_id = $_POST['course_id'];
  $course_name = $_POST['course_name'];
  $section = $_POST['section'];
  $teacher = $_POST['teacher'];

  $course = array(
    'course_id' => $course_id,
    'course_name' => $course_name,
    'section' => $section,
    'teacher' => $teacher
  );

  // Check if the course is already in the basket
  $already_added = false;
  foreach ($_SESSION['basket'] as $item) {
    if ($item['course_id'] == $course_id) {
      $already_added = true;
      break;
    }
  }

  // If the course is already in the basket, display a warning alert
  if ($already_added) {
    echo "<script>alert('This course is already in your basket.');</script>";
  } else {
    // Add the course to the session basket
    if (!isset($_SESSION['basket'])) {
      $_SESSION['basket'] = array();
    }
    array_push($_SESSION['basket'], $course);
  }
}

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$sid = $row['sid'];
    }

// Confirm the registration if the confirm button is clicked
if (isset($_POST['confirm'])) {
	// Connect to the database
	$conn = mysqli_connect("localhost", "root", "", "student_course");
	
	// Check the connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	
	// Loop through each course in the basket
	foreach ($_SESSION['basket'] as $course) {
	  $course_id = $course['course_id'];
	  $course_name = $course['course_name'];
	  $section = $course['section'];
	  $teacher = $course['teacher'];
  
	  // Insert the course into the database
	  $sql = "INSERT INTO enroll (sid,course_id, course_name, section, teacher)
	  VALUES ('$sid','$course_id', '$course_name', '$section', '$teacher')";
	  
	  if (mysqli_query($conn, $sql)) {
		echo "<script>alert('New record created successfully');</script>";
	  } else {
		echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
	  }
	}	  
	// Clear the basket
	unset($_SESSION['basket']);
	
	// Close the database connection
	mysqli_close($conn);
  }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <title>Register</title>
    <link rel="stylesheet" href="./css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
<div class="Registration">
  <h1>Registration</h1>
  <form action="" method="post">
    <label>Search by course ID:</label>
    <input type="text" name="search_term">
    <input type="submit" name="search" value="Search">
  </form>
  <?php if (isset($search_results)): ?>
    <table>
      <tr>
        <th>course_id</th>
        <th>course_name</th>
		<th>section</th>
        <th>teacher</th>
        <th>Action</th>
      </tr>
      <?php foreach ($search_results as $row): ?>
        <tr>
                <td><?php echo $row['course_id']; ?></td>
                <td><?php echo $row['course_name']; ?></td>
                <td><?php echo $row['section']; ?></td>
                <td><?php echo $row['teacher']; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                        <input type="hidden" name="course_name" value="<?php echo $row['course_name']; ?>">
                        <input type="hidden" name="section" value="<?php echo $row['section']; ?>">
                        <input type="hidden" name="teacher" value="<?php echo $row['teacher']; ?>">
                        <button type="submit" name="add" class="btn btn-outline-info">Add</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php endif; ?>
  

<?php if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])): ?>
  <h2>Enrollment Result</h2>
  <table>
    <tr>
      <th>Course ID</th>
      <th>Course Name</th>
      <th>Section</th>
      <th>Teacher</th>
      <th>Option</th>
    </tr>
    <?php foreach ($_SESSION['basket'] as $course): ?>
      <tr>
        <td><?php echo $course['course_id']; ?></td>
        <td><?php echo $course['course_name']; ?></td>
        <td><?php echo $course['section']; ?></td>
        <td><?php echo $course['teacher']; ?></td>
        <td><a href="delete.php?id=<?=$course["course_id"]?>" class="btn btn-danger">Delete</a>     </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <form action="" method="post">
    <input type="submit" name="confirm" value="Confirm Registration">
  </form>
<?php endif; ?>
</div>
</body>
</html>