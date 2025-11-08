<?php include("db.php"); session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Admin Login</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Admin Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['admin'] = $user;
        header("Location: admin_dashboard.php");
    } else {
        echo "<p>Invalid credentials!</p>";
    }
}
?>
</body>
</html>
