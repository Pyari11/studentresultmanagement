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

// Fetch all students
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");

// Handle edit request
$editStudent = null;
if (isset($_GET['edit'])) {
    $rollno = $_GET['edit'];
    $res = $conn->query("SELECT * FROM students WHERE rollno='$rollno'");
    if ($res && $res->num_rows > 0) {
        $editStudent = $res->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial; background: #f3f6ff; margin: 30px; }
        .container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ccc; }
        th { background: #007BFF; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .logout { float: right; background: #d9534f; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; }
        .logout:hover { background: #c9302c; }
        input[type=text], input[type=number], input[type=password], select { padding: 6px; border: 1px solid #ccc; border-radius: 5px; }
        input[type=submit] { background: #007BFF; color: white; padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; }
        input[type=submit]:hover { background: #0056b3; }
        h2, h3 { color: #333; }
        hr { margin: 25px 0; border: 1px solid #eee; }
        .btn { background: #007BFF; color: white; padding: 4px 10px; border-radius: 5px; text-decoration: none; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, Admin 👨‍💼</h2>
    <a href="logout.php" class="logout">Logout</a>

    <!-- ➕ Add New Student -->
    <hr>
    <h3>➕ Add New Student</h3>
    <form method="post" action="add_student.php">
        Name: <input type="text" name="name" required><br><br>
        Roll No: <input type="text" name="rollno" required><br><br>
        Department: <input type="text" name="department" required><br><br>
        Marks: <input type="number" name="marks" required><br><br>
        Result Status:
        <select name="result_status">
            <option value="Pass">Pass</option>
            <option value="Fail">Fail</option>
        </select><br><br>
        Password (for Student Login): <input type="password" name="password" required><br><br>
        <input type="submit" name="add" value="Add Student">
    </form>

    <!-- 📘 Add Subject for Student -->
    <hr>
    <h3>📘 Add Subject for a Student</h3>
    <form method="post" action="add_subject.php">
        Roll No: <input type="text" name="rollno" required><br><br>
        Subject Name: <input type="text" name="subject_name" required><br><br>
        Marks: <input type="number" name="marks" required><br><br>
        Result Status:
        <select name="result_status">
            <option value="Pass">Pass</option>
            <option value="Fail">Fail</option>
        </select><br><br>
        <input type="submit" name="add_subject" value="Add Subject">
    </form>

    <!-- ✏️ Update Student -->
    <?php if ($editStudent) { ?>
        <hr>
        <h3>✏️ Update Student Details (Roll No: <?php echo $editStudent['rollno']; ?>)</h3>
        <form method="post" action="admin_update.php">
            <input type="hidden" name="rollno" value="<?php echo $editStudent['rollno']; ?>">
            Name: <input type="text" name="name" value="<?php echo $editStudent['name']; ?>" required><br><br>
            Department: <input type="text" name="department" value="<?php echo $editStudent['department']; ?>" required><br><br>
            Marks: <input type="number" name="marks" value="<?php echo $editStudent['marks']; ?>" required><br><br>
            Result Status:
            <select name="result_status">
                <option value="Pass" <?php if ($editStudent['result_status'] == 'Pass') echo 'selected'; ?>>Pass</option>
                <option value="Fail" <?php if ($editStudent['result_status'] == 'Fail') echo 'selected'; ?>>Fail</option>
            </select><br><br>
            <input type="submit" name="update" value="Update" class="btn">
        </form>
    <?php } ?>

    <!-- 🧾 All Students Table -->
    <hr>
    <h3>📋 Student Records</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Department</th>
            <th>Marks</th>
            <th>Status</th>
            <th>Action</th>
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
                        <td><a href='?edit={$row['rollno']}' class='btn'>Edit</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No student data found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
