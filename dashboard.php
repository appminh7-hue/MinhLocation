<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// User is logged in, display the dashboard
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>This is your user dashboard where you can access your personalized content.</p>
    <!-- Add more personalized content here -->
</body>
</html>