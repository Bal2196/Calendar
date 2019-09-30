<?php
$db_connect = new mysqli('localhost', 'root', '', 'calendar');
if (mysqli_connect_errno())
    die ("Connection failed: " . $conn->connect_error);
?>