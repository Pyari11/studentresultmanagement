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

        // ✅ Check if password column exists and not empty
        if (!empty($student['password'])) {
            // Verify hashed password
            if (password_verify($password, $student['password'])) {
                $_SESSION['student'] = $roll;
                header("Location: student_dashboard.php");
                exit();
            } else {
                echo "<p style='color:red;'>❌ Invalid Password!</p>";
            }
        } else {
            echo "<p style='color:red;'>⚠️ This account does not have a password set. Please contact admin.</p>";
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
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background-color: #f3f6ff;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 320px;
            margin: auto;
        }
        h2 { text-align: center; color: #333; }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type=submit] {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #0056b3;
        }
        p { text-align: center; font-size: 14px; }
    </style>
</head>
<body>
    <h2>Student Login</h2>
    <form method="post">
        Roll Number: <input type="text" name="rollno" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
