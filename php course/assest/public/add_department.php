<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    $stmt = $conn->prepare("INSERT INTO departments (name, description, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        $success = "Department added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Department</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Add Department</h2>
  <?php if (!empty($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>
