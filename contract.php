<?php
session_start();
include 'db_connect.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: players.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM players WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

// Fetch Videos
$videos = [];
$v_sql = "SELECT * FROM player_videos WHERE player_id = $id";
$v_result = $conn->query($v_sql);
if ($v_result->num_rows > 0) {
    while ($row = $v_result->fetch_assoc()) {
        $videos[] = $row;
    }
}

if (!$player) {
    echo "Player not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Details | Football Agency</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container" style="padding: 40px; max-width: 900px; margin: 0 auto;">
        <div class="player-profile" style="display: flex; gap: 40px; margin-bottom: 40px;">
            <img src="<?php echo htmlspecialchars($player['image_url']); ?>"
                alt="<?php echo htmlspecialchars($player['name']); ?>"
                style="width: 300px; height: 300px; object-fit: cover; border-radius: 10px;">

            <div class="player-info">
                <h1 style="color: var(--primary-color); margin-top: 0;"><?php echo htmlspecialchars($player['name']); ?>
                </h1>
                <p><strong>Club:</strong> <?php echo htmlspecialchars($player['club']); ?></p>
                <p><strong>Position:</strong> <?php echo htmlspecialchars($player['position']); ?></p>
                <p><strong>Nationality:</strong> <?php echo htmlspecialchars($player['nationality']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($player['age'] ?? 'N/A'); ?></p>
                <p><strong>Market Value:</strong> $<?php echo number_format($player['market_value']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($player['market_status']); ?></p>

                <div class="actions" style="margin-top: 20px;">
                    <a href="download_report.php?id=<?php echo $player['id']; ?>" class="cta-button">Download Report</a>
                </div>
            </div>
        </div>

        <div class="contract-section"
            style="background: white; padding: 30px; border-radius: 8px; box-shadow: var(--card-shadow); margin-bottom: 30px;">
            <h2>Contract Details</h2>
            <div class="contract-dates">
                <p><strong>Start Date:</strong> <?php echo $player['contract_start']; ?></p>
                <p><strong>End Date:</strong> <?php echo $player['contract_end']; ?></p>
            </div>
        </div>

        <div class="media-section">
            <h2>Media Highlights</h2>
            <?php if (count($videos) > 0): ?>
                <div class="video-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <?php foreach ($videos as $video): ?>
                        <div class="video-item">
                            <?php if (strpos($video['video_url'], 'youtube') !== false): ?>
                                <iframe width="100%" height="200"
                                    src="<?php echo str_replace('watch?v=', 'embed/', $video['video_url']); ?>" frameborder="0"
                                    allowfullscreen></iframe>
                            <?php else: ?>
                                <video width="100%" height="200" controls>
                                    <source src="<?php echo $video['video_url']; ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No highlights available.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>