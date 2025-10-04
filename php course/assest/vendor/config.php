<?php
$host="localhost";
$user="root";
$pass="";
$db="hr_system";
$conn= new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("database is filed" . $conn->connect_error);
} 

?>