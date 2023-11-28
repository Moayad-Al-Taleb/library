<?php

$serverName = 'localhost';
$userName = 'id19384710_root';
$password = 'passwordPASSWORD123!';
$dbName = 'id19384710_library';

$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die($conn->connect_error);
}
