<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is agent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    header("Location: login.php");
    exit();
}

$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// --- DATA FETCHING ---

// 1. Market Data (Always needed for Market view)
$market_query = "SELECT * FROM players WHERE market_status = 'For Sale' OR market_status = 'Free Agent' OR market_status = 'For Loan'";
$market_result = $conn->query($market_query);

// 2. Dummy Data for Dashboard Stats
$stats = [
    'total_clients' => 12,
    'portfolio_value' => '$45.5M',
    'active_deals' => 3,
    'pending_actions' => 5
];

// 3. Dummy Data for Activity Feed
$activities = [
    ['date' => '2023-11-20', 'desc' => 'Bid submitted for Mohamed Kamara ($2M)'],
    ['date' => '2023-11-18', 'desc' => 'Contract renewal negotiations started for Alpha Turay'],
    ['date' => '2023-11-15', 'desc' => 'Meeting scheduled with LA Galaxy Reps'],
    ['date' => '2023-11-12', 'desc' => 'New sponsorship deal signed for Kei Kamara'],
];

// 4. Dummy Data for My Clients
$clients = [
    ['name' => 'Alpha Turay', 'age' => 24, 'club' => 'FC Kallon', 'value' => '$1,200,000', 'contract' => '2025', 'status' => 'Stable'],
    ['name' => 'John Doe', 'age' => 19, 'club' => 'Bo Rangers', 'value' => '$450,000', 'contract' => '2024', 'status' => 'Transfer Listed'],
    ['name' => 'Samuel Bangura', 'age' => 28, 'club' => 'East End Lions', 'value' => '$800,000', 'contract' => '2026', 'status' => 'Stable'],
    ['name' => 'David Sesay', 'age' => 21, 'club' => 'Free Agent', 'value' => '$0', 'contract' => 'N/A', 'status' => 'Seeking Club'],
];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard | Football Agency</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Setup Grid for Dashboard */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: var(--primary-color);
            margin: 10px 0;
            display: block;
        }

        /* Activity Feed */
        .activity-list {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-date {
            color: #888;
            font-size: 0.9em;
        }

        /* Clients Table */
        .clients-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .clients-table th,
        .clients-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .clients-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Market Grid (reused) */
        .market-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .player-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .player-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            position: relative;
        }

        .card-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--secondary-color);
            color: #000;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        .price-tag {
            color: green;
            font-weight: bold;
            display: block;
            margin: 10px 0;
        }

        .btn-bid {
            display: block;
            width: 100%;
            padding: 10px;
            background: var(--primary-color);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">Agent Portal</div>
            <ul class="nav-links">
                <li class="<?php echo $view == 'dashboard' ? 'active-link' : ''; ?>"><a
                        href="agent.php?view=dashboard">Dashboard</a></li>
                <li class="<?php echo $view == 'clients' ? 'active-link' : ''; ?>"><a href="agent.php?view=clients">My
                        Clients</a></li>
                <li class="<?php echo $view == 'market' ? 'active-link' : ''; ?>"><a
                        href="agent.php?view=market">Transfer Market</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero-section"
        style="min-height: 150px; background: linear-gradient(135deg, #1e3c72, #2a5298); display: flex; align-items: center; justify-content: center; color: white;">
        <div class="hero-overlay" style="text-align: center;">
            <?php if ($view == 'dashboard'): ?>
                <h1>Agent Overview</h1>
                <p>Track your portfolio and negotiations</p>
            <?php elseif ($view == 'clients'): ?>
                <h1>My Client Roster</h1>
                <p>Manage your talent portfolio</p>
            <?php elseif ($view == 'market'): ?>
                <h1>Transfer Market</h1>
                <p>Scout new talent and opportunities</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container animate-on-scroll" style="max-width: 1200px; margin: 0 auto; padding: 30px;">

        <!-- DASHBOARD VIEW -->
        <?php if ($view == 'dashboard'): ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <span>Total Clients</span>
                    <span class="stat-number"><?php echo $stats['total_clients']; ?></span>
                </div>
                <div class="stat-card">
                    <span>Portfolio Value</span>
                    <span class="stat-number"><?php echo $stats['portfolio_value']; ?></span>
                </div>
                <div class="stat-card">
                    <span>Active Negotiations</span>
                    <span class="stat-number"><?php echo $stats['active_deals']; ?></span>
                </div>
                <div class="stat-card">
                    <span>Pending Actions</span>
                    <span class="stat-number"><?php echo $stats['pending_actions']; ?></span>
                </div>
            </div>

            <h3 style="margin-bottom: 20px; color: var(--primary-color);">Recent Activity</h3>
            <div class="activity-list">
                <?php foreach ($activities as $act): ?>
                    <div class="activity-item">
                        <span><?php echo $act['desc']; ?></span>
                        <span class="activity-date"><?php echo $act['date']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <!-- CLIENTS VIEW -->
        <?php if ($view == 'clients'): ?>
            <div style="overflow-x: auto;">
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Current Club</th>
                            <th>Market Value</th>
                            <th>Contract Ends</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><strong><?php echo $c['name']; ?></strong></td>
                                <td><?php echo $c['age']; ?></td>
                                <td><?php echo $c['club']; ?></td>
                                <td><?php echo $c['value']; ?></td>
                                <td><?php echo $c['contract']; ?></td>
                                <td>
                                    <span style="padding: 3px 8px; border-radius: 10px; font-size: 0.85em; background: #eee;">
                                        <?php echo $c['status']; ?>
                                    </span>
                                </td>
                                <td><a href="#" style="color: var(--primary-color);">Manage</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>


        <!-- MARKET VIEW -->
        <?php if ($view == 'market'): ?>
            <div class="market-grid">
                <?php if ($market_result->num_rows > 0): ?>
                    <?php while ($player = $market_result->fetch_assoc()): ?>
                        <div class="player-card">
                            <div class="card-header">
                                <img src="<?php echo htmlspecialchars($player['image_url']); ?>"
                                    alt="<?php echo htmlspecialchars($player['name']); ?>">
                                <span class="status-badge"><?php echo htmlspecialchars($player['market_status']); ?></span>
                            </div>
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($player['name']); ?></h3>
                                <p style="color:#666; font-size:0.9em;"><?php echo htmlspecialchars($player['nationality']); ?> |
                                    <?php echo htmlspecialchars($player['age']); ?> yrs
                                </p>
                                <span class="price-tag">
                                    <?php echo $player['market_value'] > 0 ? '$' . number_format($player['market_value']) : 'Negotiable'; ?>
                                </span>
                                <a href="contract.php?id=<?php echo $player['id']; ?>" class="btn-bid">View Profile & Bid</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No players currently on the market.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <?php include 'footer.php'; ?>
    <script src="main.js"></script>
</body>

</html>