<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<?php
// Database connection
$host = 'localhost';
$user = 'root'; // your database username
$pass = ''; // your database password
$db = 'todo_app'; // your database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS todos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    completed TINYINT(1) DEFAULT 0
)";
$conn->query($sql);

// Handle adding a new task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $task = $conn->real_escape_string($_POST['task']);
    $sql = "INSERT INTO todos (task) VALUES ('$task')";
    $conn->query($sql);
}

// Handle updating a task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_task'])) {
    $id = $_POST['id'];
    $task = $conn->real_escape_string($_POST['task']);
    $sql = "UPDATE todos SET task='$task' WHERE id=$id";
    $conn->query($sql);
    header("Location: welcome.php"); // Redirect after update
}

// Handle deleting a task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM todos WHERE id = $id";
    $conn->query($sql);
    header("Location: welcome.php"); // Redirect after delete
}

// Fetch all tasks
$sql = "SELECT * FROM todos";
$result = $conn->query($sql);
?>

<body>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h2>Welcome</h2>
            <h1>To-Do List</h1>
            <p class="logout-link d-flex justify-content-end">
                <a href="register.php" class="btn btn-danger">Logout</a>
            </p>
        </header>

        <!-- Add Task Form -->
        <form action="" method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="task" class="form-control" placeholder="New task" required>
                <div class="input-group-append">
                    <button type="submit" name="add_task" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>

        <!-- Edit Task Form -->
        <?php if (isset($_GET['edit'])): 
            $id = $_GET['edit'];
            $edit_sql = "SELECT * FROM todos WHERE id = $id";
            $edit_result = $conn->query($edit_sql);
            $edit_task = $edit_result->fetch_assoc();
        ?>
            <h2>Edit Task</h2>
            <form action="" method="POST" class="mb-4">
                <input type="hidden" name="id" value="<?php echo $edit_task['id']; ?>">
                <div class="input-group">
                    <input type="text" name="task" value="<?php echo htmlspecialchars($edit_task['task']); ?>" class="form-control" required>
                    <div class="input-group-append">
                        <button type="submit" name="update_task" class="btn btn-success">Update</button>
                    </div>
                </div>
                <a href="welcome.php" class="btn btn-secondary mt-2">Cancel</a>
            </form>
        <?php endif; ?>

        <!-- Task List -->
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?php echo htmlspecialchars($row['task']); ?></span>
                    <div class="btn-group" role="group" style="margin-left: auto;">
                        <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                    </div>
                    <span><?php echo $row['completed'] ? '✓' : ''; ?></span>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>

    <?php include "footer.php"; ?>
</body>
</html>

<?php
$conn->close();
?>
