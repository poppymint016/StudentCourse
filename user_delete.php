<?php 
require_once 'config/db.php';

$id = $_GET['id'];

try {
    // sql to delete a record
    $sql = "DELETE FROM users WHERE id=:id";

    // use exec() because no results are returned
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว');</script>";
    echo "<script>window.location='submit.php';</script>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

$conn = null;

?>