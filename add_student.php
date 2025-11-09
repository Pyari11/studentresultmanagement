<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $rollno = $_POST['rollno'];
    $department = $_POST['department'];
    $marks = $_POST['marks'];
    $result_status = $_POST['result_status'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO students (name, rollno, department, marks, result_status, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $name, $rollno, $department, $marks, $result_status, $password);

    if ($stmt->execute()) {
        echo "<script>alert('✅ New student added successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error adding student. Maybe Roll No already exists.'); window.location='admin_dashboard.php';</script>";
    }
}
?>
