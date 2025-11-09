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

// Handle edit button click
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
        body { font-family: Arial; margin: 30px; background: #f2f6ff; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; background: white; }
        th, td { padding: 12px; text-align: center; border: 1px solid #ccc; }
        th { background-color: #2b7cff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .logout { background: red; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; float: right; }
        .logout:hover { background: darkred; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .btn { padding: 5px 10px; background: #2b7cff; color: white; border: none; border-radius: 5px; text-decoration: none; }
        .btn:hover { background: #1b5ed8; }
        input[type="text"], input[type="number"], select { padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome, Admin 👨‍💼</h2>
        <a href="logout.php" class="logout">Logout</a>

        <!-- 🔍 Search Student -->
        <h3>🔍 Search Student to Update</h3>
        <form method="get" action="">
            Roll No: <input type="text" name="edit" required>
            <input type="submit" value="Search">
        </form>

        <!-- ✏️ Update Form -->
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

        <hr>

        <!-- 🧾 Student Table -->
        <h3>Student Records</h3>
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
