<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT e.id, e.First_name, e.Last_name, e.email, e.phone, 
                               e.basic_salary, d.name AS department
                        FROM employess e
                        LEFT JOIN departments d ON e.department_id = d.id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employees</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Employees</h2>
  <a href="add_employee.php" class="btn btn-success mb-3">Add Employee</a>
  <table class="table table-bordered">
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Salary</th><th>Actions</th>
    </tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['First_name']." ".$row['Last_name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['phone'] ?></td>
  <td><?= $row['department'] ?></td>
  <td><?= $row['basic_salary'] ?></td>
  <td>
    <a href="edit_employee.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="delete_employee.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
  </td>
</tr>
<?php endwhile; ?>

  </table>
</div>
</body>
</html>
