<?php ob_start(); ?>
<?php include '../utils/html_escape.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>eSports</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/esports.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/event_grid.css">
    <script src="/js/esports.js"></script>
</head>
<body>
<div class="sidebar">
    <h1 class="websiteName">eSports</h1>
    <nav id="nav">
        <div class="menu">
            <div class="navButton">
                <!--- These hr tags are for the nav menu button on tablets and mobile devices. Hidden otherwise --->
                <hr>
                <hr>
                <hr>
            </div>
        </div>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/browse_tournaments.php">Browse Events</a></li>
            <li><a href="/organize_tournaments.php">Organize Event</a></li>
            <li><a href="/user_tournaments.php">My Tournaments</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/logout.php">Log Out</a></li>
            <?php else: ?>
                <li><a href="/login.php">Log In</a></li>
                <li><a href="/signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php if (isset($_SESSION['username'])): ?>
        <p style="position: absolute; width: 100%; text-align: center; bottom: 10px; color: orange">User: <?= $_SESSION['username'] ?></p>
    <?php endif; ?>
</div>
