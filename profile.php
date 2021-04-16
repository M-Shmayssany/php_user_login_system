<?php
include('./view/header.php'); //Including the header

//Check if there is a session
if (!isset($_SESSION['email']))
{
    // If no session redirect to login page
    header('Location: login.php');
}
else
{
    // Getting the session
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    
    echo "<h1>Hello " . $firstname . " " . $lastname . "</h1>";
}
include('./view/footer.php'); //Including the footer