<?php
session_start();
include("db.php");

// Ensure only admin can access this
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['update'])) {
    $rollno = $_POST['rollno'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $marks = $_POST['marks'];
    $result_status = $_POST['result_status'];

    // Update query
    $stmt = $conn->prepare("UPDATE students 
                            SET name = ?, department = ?, marks = ?, result_status = ? 
                            WHERE rollno = ?");
    $stmt->bind_param("ssiss", $name, $department, $marks, $result_status, $rollno);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Student record updated successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Update failed. Please check inputs.'); window.location='admin_dashboard.php';</script>";
    }
}
?>
