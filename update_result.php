<?php include("db.php"); session_start();
if(!isset($_SESSION['admin'])){ header("Location: admin_login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
<title>Update Result</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Add or Update Result</h2>
<form method="POST">
    <input type="text" name="rollno" placeholder="Roll No" required>
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <input type="number" name="marks" placeholder="Marks" required>
    <input type="password" name="password" placeholder="Student Password" required>
    <button type="submit" name="save">Save</button>
</form>

<?php
if(isset($_POST['save'])){
    $roll = $_POST['rollno'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $pass = $_POST['password'];

    $check = $conn->query("SELECT * FROM students WHERE rollno='$roll'");
    if($check->num_rows > 0){
        $conn->query("UPDATE students SET name='$name', subject='$subject', marks='$marks' WHERE rollno='$roll'");
        echo "<p>Result updated successfully!</p>";
    } else {
        $conn->query("INSERT INTO students (rollno, name, subject, marks, password) VALUES ('$roll', '$name', '$subject', '$marks', '$pass')");
        echo "<p>New result added!</p>";
    }
}
?>
</body>
</html>
