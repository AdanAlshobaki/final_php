<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: employees.php?error=missing_id");
    exit;
}

$id = intval($_GET['id']); 
//delete employee
$sql = "DELETE FROM employess WHERE id = $id";
if ($conn->query($sql)) {
    header("Location: employees.php?success=deleted");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
