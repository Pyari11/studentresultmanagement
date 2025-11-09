<?php
session_start();
include("db.php");

// Restrict access unless logged in
if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}

$roll = $_SESSION['student'];

// Fetch student data safely
$stmt = $conn->prepare("SELECT * FROM students WHERE rollno = ?");
$stmt->bind_param("s", $roll);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($roll); ?> 👨‍🎓</h2>
    <a href="logout.php">Logout</a>

    <h3>Your Result</h3>
    <table border="1">
        <tr>
            <th>Roll No</th>
            <th>Name</th>
            <th>Department</th>
            <th>Marks</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['rollno']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['marks']}</td>
                        <td>{$row['result_status']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No result found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
