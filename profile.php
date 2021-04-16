<?php
include('./view/header.php');
if (!isset($_SESSION['email']))
{
    header('Location: login.php');
}
else
{
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    
    echo "<h1>Hello " . $firstname . " " . $lastname . "</h1>";
}
include('./view/footer.php');