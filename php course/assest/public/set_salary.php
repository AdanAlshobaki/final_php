<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("UPDATE employess SET basic_salary=? WHERE id=?");
    $stmt->bind_param("di", $salary, $employee_id);
    $stmt->execute();

    $success = "Salary updated successfully!";
}


$employees = $conn->query("SELECT id, first_name, last_name, basic_salary FROM employess");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center"> Set Employee Salary</h3>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"><?= $success ?></div>
        <?php endif; ?>

        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Select Employee</label>
                <select name="employee_id" class="form-select" required>
                    <?php while($row = $employees->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['first_name'] ?> <?= $row['last_name'] ?> (Current: <?= $row['basic_salary'] ?> JOD)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Salary (JOD)</label>
                <input type="number" name="salary" step="0.01" class="form-control" required>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-dark px-4">Update Salary</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
