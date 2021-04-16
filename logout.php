<?php

// Include header
include('./view/header.php'); 

// Unset and destroy session
session_unset();
session_destroy();

// Redirect to home page
header('Location: index.php');