<?php
session_start();
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: players.php");
            } else if ($row['role'] === 'manager') {
                header("Location: manager.php");
            } else if ($row['role'] === 'agent') {
                header("Location: agent.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "No user found with this email.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Football Agency</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="auth-container animate-on-scroll">
        <h2>Login</h2>
        <?php if ($message)
            echo "<p class='error-msg'>$message</p>"; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
    <?php include 'footer.php'; ?>
    <script src="main.js"></script>
</body>

</html>