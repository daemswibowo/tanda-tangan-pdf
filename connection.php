<?php 
$conn = new mysqli('localhost', 'root', 'itusihdl', 'pdf');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
