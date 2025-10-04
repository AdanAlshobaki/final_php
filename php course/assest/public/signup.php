<?php
//adan pass 123 ,admin 1234
session_start();
include "../vendor/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Username already in use";
     } else {
        $stmt = $conn->prepare("INSERT INTO users (name, username, password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $username, $hashedPass);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_name'] = $name;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "An error occurred while creating the account.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 400px;">
  <h3 class="mb-3 text-center">Creat new acouunt</h3>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">FullName</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">UserName</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Signup</button>
    <p class="mt-3 text-center">Have acouunt?<a href="login.php">Login</a></p>
  </form>
</div>

</body>
</html>
