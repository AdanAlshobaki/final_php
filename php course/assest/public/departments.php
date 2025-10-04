<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT d.id, d.name, d.description, COUNT(e.id) as employee_count 
        FROM departments d 
        LEFT JOIN employess e ON d.id = e.department_id 
        GROUP BY d.id";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Departments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Departments</h2>
  <a href="add_department.php" class="btn btn-success mb-3">Add Department</a>
  <table class="table table-bordered">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Employees</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['description'] ?></td>
      <td><?= $row['employee_count'] ?></td>
      <td>
        <a href="edit_departments.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete_departments.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
