<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is admin or agent
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'agent')) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $club = $_POST['club'];
    $age = $_POST['age'];
    $nationality = $_POST['nationality'];
    $position = $_POST['position'];

    // Handle File Upload
    $target_dir = "uploads/";
    // Ensure filename is unique or handles special chars to prevent issues
    $filename = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message = "File is not an image.";
            $uploadOk = 0;
        }
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Success upload, insert into DB
            $image_url = $target_file; // Store path relative to root

            $owner_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("INSERT INTO players (name, club, age, image_url, nationality, position, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisssi", $name, $club, $age, $image_url, $nationality, $position, $owner_id);

            if ($stmt->execute()) {
                header("Location: players.php");
                exit();
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();

        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player | Football Agency</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="form-container animate-on-scroll">
        <h2>Add New Player</h2>
        <?php if ($message)
            echo "<p style='color:red;'>$message</p>"; ?>
        <!-- Added enctype for file upload -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Club</label>
                <input type="text" name="club" required>
            </div>
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" required placeholder="e.g. Forward, Midfielder, Goalkeeper">
            </div>
            <div class="form-group">
                <label>Nationality</label>
                <input type="text" name="nationality" required placeholder="e.g. Sierra Leone">
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" required>
            </div>
            <div class="form-group">
                <label>Player Image</label>
                <input type="file" name="image" required accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Add Player</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="main.js"></script>
</body>

</html>