<?php
session_start();
include "../vendor/config.php";

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password, role, employee_id FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $dbUsername, $hashedPass, $dbRole, $employee_id);
    $stmt->fetch();

    if ($stmt->num_rows == 0) {
        $error = "username is incorrect";
    } elseif (!password_verify($password, $hashedPass)) {
        $error = "password is incorrect";
    } else {
        $_SESSION['user_id']      = $id;
        $_SESSION['user_name']    = $dbUsername;
        $_SESSION['role']         = $dbRole;       
        $_SESSION['employee_id']  = $employee_id;  
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 400px;">
  <h3 class="mb-3 text-center">Login</h3>
 <?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-dark w-100">Login</button>
    <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Create account</a></p>
  </form>
</div>

</body>
</html>
