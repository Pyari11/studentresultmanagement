<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {
    $roll = trim($_POST['rollno']);
    $password = trim($_POST['password']);

    // Prepare query safely
    $stmt = $conn->prepare("SELECT * FROM students WHERE rollno = ?");
    $stmt->bind_param("s", $roll);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $student = $result->fetch_assoc();

        // Verify password hash
        if (password_verify($password, $student['password'])) {
            $_SESSION['student'] = $roll;
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "<p style='color:red;'>❌ Invalid Password!</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Roll Number not found!</p>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="font-family:Arial; margin:40px;">
<h2>Student Login</h2>
<form method="post">
    Roll Number: <input type="text" name="rollno" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" name="login" value="Login">
</form>
</body>
</html>
