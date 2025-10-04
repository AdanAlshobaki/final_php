<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$employee_id = $_SESSION['employee_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, department_id, basic_salary FROM employess WHERE id=?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$emp = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payslip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-5">
        <h3 class="mb-4 text-center"> Employee Payslip</h3>
        <table class="table table-bordered">
            <tr>
                <th>Employee</th>
                <td><?= $emp['first_name'] . " " . $emp['last_name'] ?></td>
            </tr>
            <tr>
                <th>Department ID</th>
                <td><?= $emp['department_id'] ?></td>
            </tr>
            <tr>
                <th>Basic Salary</th>
                <td><?= number_format($emp['basic_salary'], 2) ?> JOD</td>
            </tr>
            <tr>
                <th>Date</th>
                <td><?= date("F Y") ?></td>
            </tr>
        </table>
        <div class="text-center mt-3">
            <button class="btn btn-dark" onclick="window.print()"> Print Payslip</button>
        </div>
    </div>
</div>

</body>
</html>
