<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Invalid request!");
}

$id = intval($_GET['id']);

// Delete department
$stmt = $conn->prepare("DELETE FROM departments WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: departments.php");
    exit;
} else {
    die("Error deleting department: " . $conn->error);
}
