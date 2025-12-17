<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

// Handle User Creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Admin created users are verified by default
    $is_verified = 1;

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, is_verified) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $username, $email, $password, $role, $is_verified);

    if ($stmt->execute()) {
        $message = "User created successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle User Deletion
if (isset($_POST['delete_user_id'])) {
    $delete_id = $_POST['delete_user_id'];

    // Prevent deleting self
    if ($delete_id != $_SESSION['user_id']) {
        $conn->query("DELETE FROM users WHERE id=$delete_id");
        $message = "User deleted.";
    } else {
        $message = "Cannot delete yourself.";
    }
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="form-container animate-on-scroll">
        <h2>Create Privileged User</h2>
        <?php if ($message)
            echo "<div class='alert alert-success'>$message</div>"; ?>

        <form method="POST" action="">
            <input type="hidden" name="create_user" value="1">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="manager">Club Manager</option>
                    <option value="agent">Agent</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>

    <div class="admin-table-wrapper animate-on-scroll">
        <h3>Existing Users</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td style="font-weight:bold; color: var(--primary-color);">
                                <?php echo ucfirst($row['role']); ?>
                            </td>
                            <td>
                                <?php if ($row['id'] != $_SESSION['user_id']): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Delete user?');">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color:#aaa;">(You)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
    <script src="main.js"></script>
</body>

</html>