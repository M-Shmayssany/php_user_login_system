<?php
    // Starting the session
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Challeng</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand">PHP</a>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/register.php" tabindex="-1" aria-disabled="true">Register</a>
            </li>
            <?php
            //Check if there is a session
            if (isset($_SESSION['email']))
            {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="/profile.php" tabindex="-1" aria-disabled="true">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout.php" tabindex="-1" aria-disabled="true">Logout</a>
            </li>
            <?php
            }
            else
            {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="/login.php" tabindex="-1" aria-disabled="true">Login</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>