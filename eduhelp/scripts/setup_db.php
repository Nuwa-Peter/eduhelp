<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduhelp";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully\n";
} else {
  echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db($dbname);

// SQL to create table
$sql = file_get_contents('eduhelp.sql');

if ($conn->multi_query($sql)) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
