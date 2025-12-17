<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$is_logged_in = isset($_SESSION['user_id']);
?>
<header>
    <nav class="navbar">
        <a href="index.php" class="logo">
            <img src="images/logo_icon.png" alt="LionSport Agency Badge">
            <span class="logo-text">LionSport Agency</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="players.php">Players</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if ($is_logged_in): ?>
                <?php if ($is_admin): ?>
                    <li><a href="admin_users.php">Manage Users</a></li>
                    <li><a href="admin_contacts.php">Submissions</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>