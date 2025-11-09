<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['add_subject'])) {
    $rollno = $_POST['rollno'];
    $subject_name = $_POST['subject_name'];
    $marks = $_POST['marks'];
    $result_status = $_POST['result_status'];

    $stmt = $conn->prepare("INSERT INTO subjects (rollno, subject_name, marks, result_status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $rollno, $subject_name, $marks, $result_status);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Subject added successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error adding subject.'); window.location='admin_dashboard.php';</script>";
    }
}
?>
