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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name   = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $email        = trim($_POST['email']);
    $phone        = trim($_POST['phone']);
    $department   = $_POST['department_id'];
    $hire_date    = $_POST['hire_date'];
    $salary       = $_POST['salary'];

    $stmt = $conn->prepare("UPDATE employess 
                            SET first_name=?, last_name=?, email=?, phone=?, department_id=?, hire_date=?, basic_salary=? 
                            WHERE id=?");
    $stmt->bind_param("ssssissi", $first_name, $last_name, $email, $phone, $department, $hire_date, $salary, $id);

    if ($stmt->execute()) {
        header("Location: employees.php");
        exit;
    } else {
        $error = "Error updating employee: " . $conn->error;
    }
}

$result = $conn->prepare("SELECT * FROM employess WHERE id=?");
$result->bind_param("i", $id);
$result->execute();
$data = $result->get_result()->fetch_assoc();

if (!$data) {
    die("Employee not found!");
}


$departments = $conn->query("SELECT id, name FROM departments");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Edit Employee</h2>
  <?php if (!empty($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label>First Name</label>
      <input type="text" name="first_name" class="form-control" value="<?= $data['First_name'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Last Name</label>
      <input type="text" name="last_name" class="form-control" value="<?= $data['Last_name'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
    </div>
    <div class="mb-3">
      <label>Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= $data['phone'] ?>">
    </div>
    <div class="mb-3">
      <label>Department</label>
      <select name="department_id" class="form-select">
        <option value="">-- Select Department --</option>
        <?php while ($d = $departments->fetch_assoc()): ?>
            <option value="<?= $d['id'] ?>" <?= ($d['id'] == $data['department_id']) ? 'selected' : '' ?>>
                <?= $d['name'] ?>
            </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Hire Date</label>
      <input type="date" name="hire_date" class="form-control" value="<?= $data['hire_date'] ?>">
    </div>
    <div class="mb-3">
      <label>Basic Salary</label>
      <input type="number" step="0.01" name="salary" class="form-control" value="<?= $data['basic_salary'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="employees.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
