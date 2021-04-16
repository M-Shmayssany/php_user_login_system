<?php
$server = "localhost";
$userName = "root";
$password = "";
$dbname = "myAuth";
$conn_massage = "";
try {
  $conn = new PDO("mysql:host=$server;dbname=" . $dbname, $userName, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn_massage = "";
} catch(PDOException $e) {
  $conn_massage = "Connection failed: " . $e->getMessage();
}
?>