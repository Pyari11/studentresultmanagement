<?php
session_start();
include("db.php");

// Optional: make sure only admin can access
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all student records
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - View & Update Students</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:hover { background-color: #f9f9f9; }
        a { text-decoration: none; color: blue; }
        a.logout { color: red; float: right; }
        form { margin-top: 30px; }
        input, select { padding: 6px; width: 200px; }
    </style>
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

    <!-- ✅ Add the form below the table -->
    <h3>Add or Update Student Marks</h3>
    <form method="post" action="admin_update.php">
        Roll No: <input type="text" name="rollno" required><br><br>
        Department: <input type="text" name="department" required><br><br>
        Marks: <input type="number" name="marks" required><br><br>
        Result Status:
        <select name="result_status">
            <option value="Pass">Pass</option>
            <option value="Fail">Fail</option>
        </select><br><br>
        <input type="submit" name="update" value="Save">
    </form>

</body>
</html>
