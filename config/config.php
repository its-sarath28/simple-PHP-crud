<?php

$server = "localhost";
$userId = "root";
$password = "";
$dbName = "crud";

$conn = new mysqli($server, $userId, $password, $dbName);

if ($conn->connect_error) {
    die("Error connecting to DB" . $conn->connect_error);
}
