<?php include("db.php"); session_start();
if(!isset($_SESSION['admin'])){ header("Location: admin_login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['admin']; ?> 👩‍💼</h2>
<a href="update_result.php">Add/Update Result</a> |
<a href="logout.php">Logout</a>

<h3>All Student Results</h3>
<table border="1">
<tr><th>Roll No</th><th>Name</th><th>Subject</th><th>Marks</th></tr>
<?php
$result = $conn->query("SELECT * FROM students");
while($row = $result->fetch_assoc()){
    echo "<tr><td>{$row['rollno']}</td><td>{$row['name']}</td><td>{$row['subject']}</td><td>{$row['marks']}</td></tr>";
}
?>
</table>
</body>
</html>
