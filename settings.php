<?php
$host = "localhost";
$user = "root";
$pwd = "";
$sql_db = "jobs"; 

$conn = mysqli_query($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Connection failed: " . mysqli_query_error());
}
?>