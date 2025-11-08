<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {
    $roll = $_POST['rollno'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM students WHERE rollno='$roll' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['student'] = $roll;
        header("Location: student_dashboard.php");
        exit(); // ✅ ensures redirect before HTML output
    } else {
        $error = "Invalid Roll No or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Student Login</h2>
<form method="POST">
    <input type="text" name="rollno" placeholder="Roll No" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
</body>
</html>
