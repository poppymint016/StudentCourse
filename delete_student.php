<?php
session_start();
require_once 'config/db.php';

if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];
    try {
        $conn->beginTransaction();
        
        // Delete records from the enroll table for the given student ID
        $stmt1 = $conn->prepare("DELETE FROM enroll WHERE sid = :sid");
        $stmt1->bindParam(':sid', $sid);
        $stmt1->execute();
        
        // Delete the record from the users table for the given student ID
        $stmt2 = $conn->prepare("DELETE FROM users WHERE sid = :sid");
        $stmt2->bindParam(':sid', $sid);
        $stmt2->execute();
        
        $conn->commit();
        $_SESSION['success'] = 'ลบข้อมูลนิสิตเรียบร้อยแล้ว';
    } catch (PDOException $e) {
        $conn->rollBack();
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการลบข้อมูลนิสิต';
    }
}

header('location: admin_student.php');
exit;
