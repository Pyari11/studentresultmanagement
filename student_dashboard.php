<?php include("db.php"); session_start();
if(!isset($_SESSION['student'])){ header("Location: student_login.php"); exit(); }
$roll = $_SESSION['student'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Welcome, <?php echo $roll; ?> 👨‍🎓</h2>
<a href="logout.php">Logout</a>

<h3>Your Result</h3>
<table border="1">
<tr><th>Roll No</th><th>Name</th><th>Subject</th><th>Marks</th></tr>
<?php
$result = $conn->query("SELECT * FROM students WHERE rollno='$roll'");
while($row = $result->fetch_assoc()){
    echo "<tr><td>{$row['rollno']}</td><td>{$row['name']}</td><td>{$row['subject']}</td><td>{$row['marks']}</td></tr>";
}
?>
</table>
</body>
</html>
