<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// --- DATA FETCHING ---

// 1. Squad Data (Always used for Squad view, maybe summary for stats)
$squad_result = $conn->query("SELECT * FROM players LIMIT 15");

// 2. Dummy League Table
$league_table = [
    ['pos' => 1, 'team' => 'LionSport FC', 'p' => 15, 'w' => 12, 'd' => 2, 'l' => 1, 'pts' => 38],
    ['pos' => 2, 'team' => 'Eastern Lions', 'p' => 15, 'w' => 10, 'd' => 3, 'l' => 2, 'pts' => 33],
    ['pos' => 3, 'team' => 'Kallon FC', 'p' => 15, 'w' => 9, 'd' => 4, 'l' => 2, 'pts' => 31],
    ['pos' => 4, 'team' => 'Bo Rangers', 'p' => 15, 'w' => 8, 'd' => 5, 'l' => 2, 'pts' => 29],
    ['pos' => 5, 'team' => 'East End Lions', 'p' => 15, 'w' => 7, 'd' => 4, 'l' => 4, 'pts' => 25],
];

// 3. Dummy Match Schedule
$matches = [
    ['date' => '2023-10-15', 'opponent' => 'Bo Rangers', 'venue' => 'Home', 'result' => '3 - 1 (W)'],
    ['date' => '2023-10-22', 'opponent' => 'Kallon FC', 'venue' => 'Away', 'result' => '1 - 1 (D)'],
    ['date' => '2023-11-05', 'opponent' => 'Eastern Lions', 'venue' => 'Home', 'result' => 'Upcoming'],
];

// 4. Dummy Training Schedule
$training_schedule = [
    'Monday' => ['am' => 'Recovery Session', 'pm' => 'Video Analysis'],
    'Tuesday' => ['am' => 'Fitness & Conditioning', 'pm' => 'Tactical Drills'],
    'Wednesday' => ['am' => 'Small Sided Games', 'pm' => 'Set Pieces'],
    'Thursday' => ['am' => 'Individual Skills', 'pm' => 'Rest'],
    'Friday' => ['am' => 'Match Prep', 'pm' => 'Travel'],
];

// 5. Dummy Injury Report
$injuries = [
    ['player' => 'John Kamara', 'injury' => 'Hamstring Strain', 'return' => '2 Weeks'],
    ['player' => 'David Bangura', 'injury' => 'Ankle Sprain', 'return' => '3 Days'],
];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard | Football Agency</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
        }

        .win {
            color: green;
            font-weight: bold;
        }

        .draw {
            color: orange;
            font-weight: bold;
        }

        .loss {
            color: red;
            font-weight: bold;
        }

        /* Training Schedule Specifics */
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* Mon - Fri */
            gap: 15px;
        }

        .day-card {
            background: #fdfdfd;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .day-header {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
            display: block;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .session-block {
            margin: 10px 0;
            font-size: 0.9em;
        }

        .session-label {
            font-weight: bold;
            color: #555;
            display: block;
            font-size: 0.8em;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">Manager Panel</div>
            <ul class="nav-links">
                <li class="<?php echo $view == 'dashboard' ? 'active-link' : ''; ?>"><a
                        href="manager.php?view=dashboard">Dashboard</a></li>
                <li class="<?php echo $view == 'squad' ? 'active-link' : ''; ?>"><a
                        href="manager.php?view=squad">Squad</a></li>
                <li class="<?php echo $view == 'training' ? 'active-link' : ''; ?>"><a
                        href="manager.php?view=training">Training</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero-section"
        style="min-height: 150px; background: linear-gradient(135deg, #2c3e50, #4ca1af); display: flex; align-items: center; justify-content: center; color: white;">
        <div class="hero-overlay" style="text-align: center;">
            <?php if ($view == 'dashboard'): ?>
                <h1>Club Overview</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <?php elseif ($view == 'squad'): ?>
                <h1>Squad Management</h1>
                <p>Player Performance & Stats</p>
            <?php elseif ($view == 'training'): ?>
                <h1>Training & Physio</h1>
                <p>Prepare for matchday</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container animate-on-scroll" style="max-width: 1200px; margin: 0 auto; padding: 30px;">

        <!-- DASHBOARD VIEW -->
        <?php if ($view == 'dashboard'): ?>
            <div class="dashboard-grid">
                <!-- Overview Stats -->
                <div class="dashboard-card" style="display:flex; justify-content:space-around; align-items:center;">
                    <div style="text-align:center;">
                        <span style="display:block; font-size:2em; font-weight:bold; color:var(--primary-color);">3rd</span>
                        <span>League Pos</span>
                    </div>
                    <div style="text-align:center;">
                        <span style="display:block; font-size:2em; font-weight:bold; color:var(--primary-color);">38</span>
                        <span>Points</span>
                    </div>
                    <div style="text-align:center;">
                        <span style="display:block; font-size:2em; font-weight:bold; color:var(--primary-color);">+25</span>
                        <span>Goal Diff</span>
                    </div>
                </div>

                <!-- Match Schedule -->
                <div class="dashboard-card">
                    <h3>Recent & Upcoming Matches</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Opponent</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matches as $match): ?>
                                <tr>
                                    <td><?php echo $match['date']; ?></td>
                                    <td><?php echo $match['opponent']; ?> (<?php echo $match['venue']; ?>)</td>
                                    <td>
                                        <?php
                                        if (strpos($match['result'], 'W') !== false) {
                                            echo '<span class="win">' . $match['result'] . '</span>';
                                        } elseif (strpos($match['result'], 'D') !== false) {
                                            echo '<span class="draw">' . $match['result'] . '</span>';
                                        } elseif (strpos($match['result'], 'L') !== false) {
                                            echo '<span class="loss">' . $match['result'] . '</span>';
                                        } else {
                                            echo $match['result'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- League Table -->
                <div class="dashboard-card">
                    <h3>League Table</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Pos</th>
                                <th>Team</th>
                                <th>P</th>
                                <th>Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($league_table as $row): ?>
                                <tr <?php if ($row['pos'] == 1)
                                    echo 'style="background-color: #e8f5e9;"'; ?>>
                                    <td><?php echo $row['pos']; ?></td>
                                    <td><?php echo $row['team']; ?></td>
                                    <td><?php echo $row['p']; ?></td>
                                    <td><strong><?php echo $row['pts']; ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>


        <!-- SQUAD VIEW -->
        <?php if ($view == 'squad'): ?>
            <div class="dashboard-card">
                <h3>Player Statistics</h3>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Player</th>
                                <th>Role</th>
                                <th>Apps</th>
                                <th>Goals</th>
                                <th>Assists</th>
                                <th>Avg Rating</th>
                                <th>Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($squad_result->num_rows > 0): ?>
                                <?php while ($player = $squad_result->fetch_assoc()): ?>
                                    <?php
                                    // Random Stats Generation
                                    $apps = rand(5, 15);
                                    $goals = rand(0, 8);
                                    $assists = rand(0, 5);
                                    $rating = rand(60, 90) / 10;
                                    $condition = rand(80, 100);
                                    ?>
                                    <tr>
                                        <td style="display:flex; align-items:center; gap:10px;">
                                            <img src="<?php echo htmlspecialchars($player['image_url']); ?>"
                                                style="width:30px; height:30px; border-radius:50%; object-fit:cover;">
                                            <?php echo htmlspecialchars($player['name']); ?>
                                        </td>
                                        <td>First Team</td>
                                        <td><?php echo $apps; ?></td>
                                        <td><?php echo $goals; ?></td>
                                        <td><?php echo $assists; ?></td>
                                        <td><strong><?php echo $rating; ?></strong></td>
                                        <td>
                                            <div style="width: 50px; height: 6px; background: #ddd; border-radius:3px;">
                                                <div
                                                    style="width: <?php echo $condition; ?>%; height: 100%; background: <?php echo $condition > 90 ? 'green' : 'orange'; ?>; border-radius:3px;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No players found in database. Add players as Admin first.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>


        <!-- TRAINING VIEW -->
        <?php if ($view == 'training'): ?>
            <div class="dashboard-grid">
                <!-- Weekly Schedule -->
                <div class="dashboard-card" style="grid-column: 1 / -1;">
                    <h3>Weekly Training Schedule</h3>
                    <div class="schedule-grid">
                        <?php foreach ($training_schedule as $day => $sessions): ?>
                            <div class="day-card">
                                <span class="day-header"><?php echo $day; ?></span>
                                <div class="session-block">
                                    <span class="session-label">Morning</span>
                                    <?php echo $sessions['am']; ?>
                                </div>
                                <div class="session-block">
                                    <span class="session-label">Afternoon</span>
                                    <?php echo $sessions['pm']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Injury Report -->
                <div class="dashboard-card" style="grid-column: 1 / -1;">
                    <h3>Physio Room / Injury Report</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Player</th>
                                <th>Injury</th>
                                <th>Expected Return</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($injuries as $injury): ?>
                                <tr>
                                    <td><?php echo $injury['player']; ?></td>
                                    <td><?php echo $injury['injury']; ?></td>
                                    <td><?php echo $injury['return']; ?></td>
                                    <td><span style="color:red; font-weight:bold;">Unavailable</span></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4" style="text-align:center; color:#888;">No other serious injuries reported.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <?php include 'footer.php'; ?>
    <script src="main.js"></script>
</body>

</html>