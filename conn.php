<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "exam";

try {
  $conn = new PDO("mysql:host={$host};dbname={$db};",$user,$pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  $conn = null; 
  // exit(); 
}


 ?>