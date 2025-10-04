<?php
session_start();
include "../vendor/config.php";

// check if user is login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// check if ID is passed
if (!isset($_GET['id'])) {
    die("Invalid request!");
}

$id = intval($_GET['id']);

// handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);

    $stmt = $conn->prepare("UPDATE departments SET name=?, description=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $description, $id);

    if ($stmt->execute()) {
        header("Location: departments.php");
        exit;
    } else {
        $error = "Error updating department: " . $conn->error;
    }
}

// get department data
$result = $conn->prepare("SELECT * FROM departments WHERE id=?");
$result->bind_param("i", $id);
$result->execute();
$data = $result->get_result()->fetch_assoc();

if (!$data) {
    die("Department not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Department</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Edit Department</h2>
  <?php if (!empty($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control"><?= $data['description'] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="departments.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
