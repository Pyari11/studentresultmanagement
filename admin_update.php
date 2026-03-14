<?php
include("db.php");

if (isset($_POST['update'])) {
    $roll = $_POST['rollno'];
    $dept = $_POST['department'];
    $marks = $_POST['marks'];
    $status = $_POST['result_status'];

    // Update if student exists, else insert
    $check = $conn->query("SELECT * FROM students WHERE rollno='$roll'");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE students SET department='$dept', marks='$marks', result_status='$status' WHERE rollno='$roll'");
        echo "<p style='color:green;'>✅ Student updated successfully!</p>";
    } else {
        $conn->query("INSERT INTO students (name, rollno, department, marks, result_status) VALUES ('Unknown', '$roll', '$dept', '$marks', '$status')");
        echo "<p style='color:blue;'>ℹ️ New student record added!</p>";
    }
    echo "<a href='admin_dashboard.php'>← Go Back</a>";
}
?>
