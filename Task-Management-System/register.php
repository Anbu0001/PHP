<!DOCTYPE html>
<html lang="en">
    
<?php include 'head.php'; ?>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Register Form</h2>
        <main class="animated fadeIn"> <!-- Add animation class here -->
            <form method="POST" novalidate>
                <div class="form-group">
                    <label for="usersname">User Name:</label>
                    <input type="text" class="form-control" name="usersname" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control" name="age" placeholder="Age" required>
                </div>
                <div class="form-group">
                    <label for="number">Phone Number:</label>
                    <input type="tel" class="form-control" name="number" placeholder="Mobile Number" required>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail:</label>
                    <input type="email" class="form-control" name="email" placeholder="Mail" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Your Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php">Login</a>
            </div>
        </main>

        <?php
            // Database connection and form handling (remains the same)
            $servername = "localhost";
            $dbusername = "root"; 
            $dbpassword = ""; 
            $dbname = "todo_app";

            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $error = "";
                $usersname = trim($_POST['usersname']);
                $age = (int)$_POST['age'];
                $number = trim($_POST['number']);
                $email = trim($_POST['email']);
                $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

                if (empty($usersname) || empty($email) || empty($number) || empty($password)) {
                    $error = "All fields are required.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Invalid email format.";
                } elseif (strlen($number) != 10) {
                    $error = "Phone number must be 10 digits.";
                }

                if (empty($error)) {
                    $stmt = $conn->prepare("INSERT INTO users (usersname, age, number, email, password) VALUES (?, ?, ?, ?, ?)");
                    
                    if ($stmt) {
                        $stmt->bind_param("siiss", $usersname, $age, $number, $email, $password);
                        if ($stmt->execute()) {
                            echo "<p class='text-success'>Registration successful! Redirecting to login...</p>";
                            header("refresh:2;url=login.php"); // Redirect after 2 seconds
                            exit();
                        } else {
                            echo "<p class='text-danger'>Error: " . $stmt->error . "</p>";
                        }
                        $stmt->close();
                    } else {
                        echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p class='text-danger'>Error: $error</p>";
                }
            }

            $conn->close(); 
        ?>
    </div>

    <?php include "footer.php"; ?>

    
</body>
</html>
