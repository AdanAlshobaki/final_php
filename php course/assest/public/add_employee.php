<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name   = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $email        = trim($_POST['email']);
    $phone        = trim($_POST['phone']);
    $department   = $_POST['department_id'];
    $hire_date    = $_POST['hire_date'];
    $salary       = $_POST['salary'];

    $stmt = $conn->prepare("INSERT INTO employess (first_name, last_name, email, phone, department_id, hire_date, basic_salary) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssisd", $first_name, $last_name, $email, $phone, $department, $hire_date, $salary);

    if ($stmt->execute()) {
        $success = "Employee added successfully!";
            header("Location: employees.php");   

    } else {
        $error = "Error adding employee: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Add Employee</h2>
  <?php if (!empty($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label>First Name</label>
      <input type="text" name="first_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Last Name</label>
      <input type="text" name="last_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
      <label>Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
      <label>Department</label>
      <select name="department_id" class="form-select">
        <option value="">-- Select Department --</option>
        <?php
      $departments = $conn->query("SELECT id, name FROM departments");
if ($departments->num_rows == 0) {
    echo "<option value=''>No departments available</option>";
} else {
    while ($d = $departments->fetch_assoc()) {
        echo "<option value='{$d['id']}'>{$d['name']}</option>";
    }
}

        ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Hire Date</label>
      <input type="date" name="hire_date" class="form-control">
    </div>
    <div class="mb-3">
      <label>Basic Salary</label>
      <input type="number" step="0.01" name="salary" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>
