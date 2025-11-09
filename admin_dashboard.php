<?php
session_start();
include("db.php");

// Auto logout after 10 minutes
$timeout_duration = 600;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php?session=expired");
    exit();
}

$_SESSION['last_activity'] = time();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Welcome, Admin 👨‍💼</h2>
    <a href="logout.php" class="logout">Logout</a>

    <h3>Student Records</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Department</th>
            <th>Marks</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['rollno']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['marks']}</td>
                        <td>{$row['result_status']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No student data found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
