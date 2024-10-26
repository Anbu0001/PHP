<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Login Form</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="usersname">Username:</label>
                <input type="text" class="form-control" name="usersname" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
            <p><a href="welcome.php">Continue as Guest</a></p>
        </div>
        <?php
        session_start();

        // Database connection
        $host = 'localhost';
        $dbname = 'todo_app';
        $db_username = 'root';
        $db_password = '';

        // Create a MySQLi connection
        $mysqli = new mysqli($host, $db_username, $db_password, $dbname);

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input_username = $mysqli->real_escape_string($_POST['usersname']);
            $input_password = $_POST['password'];

            // Prepare the SQL statement
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE usersname = ?");

            // Check if prepare was successful
            if (!$stmt) {
                die("Prepare failed: " . $mysqli->error);
            }

            $stmt->bind_param('s', $input_username);
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($input_password, $user['password'])) {
                // Successful login
                $_SESSION['usersname'] = $user['usersname'];
                header("Location: welcome.php"); // Redirect to a welcome page
                exit();
            } else {
                // Invalid credentials
                echo "<div class='alert alert-danger mt-3'>Invalid username or password.</div>";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the connection
        $mysqli->close();
        ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
