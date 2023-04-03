<?php
$conn = new mysqli("localhost", "root", "5395", "user");
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

?> 