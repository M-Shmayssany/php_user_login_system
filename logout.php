<?php
include('./view/header.php');
session_unset();
session_destroy();
header('Location: index.php');