<?php
session_start();
include "../vendor/config.php";

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// جلب كل الموظفين للـ dropdown
$employees = $conn->query("SELECT id, First_name, Last_name FROM employess");

// إذا اختار المستخدم موظف
$selected_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;

// جلب سجل الحضور إذا تم اختيار موظف
$attendanceData = [];
if ($selected_id > 0) {
    $stmt = $conn->prepare("SELECT attendance_date, status FROM attendance WHERE employee_id=? ORDER BY attendance_date DESC");
    $stmt->bind_param("i", $selected_id);
    $stmt->execute();
    $attendanceData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Employee Attendance Record</h2>

    <form method="get" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="employee_id" class="col-form-label">Select Employee:</label>
            </div>
            <div class="col-auto">
                <select name="employee_id" id="employee_id" class="form-select" required>
                    <option value="">-- Select Employee --</option>
                    <?php while ($emp = $employees->fetch_assoc()): ?>
                        <option value="<?= $emp['id'] ?>" <?= ($emp['id'] == $selected_id) ? 'selected' : '' ?>>
                            <?= $emp['First_name'] . " " . $emp['Last_name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">View Attendance</button>
            </div>
        </div>
    </form>

    <?php if ($selected_id > 0): ?>
        <h4>Attendance for Employee ID: <?= $selected_id ?></h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($attendanceData)): ?>
                <?php foreach ($attendanceData as $row): ?>
                    <tr>
                        <td><?= $row['attendance_date'] ?></td>
                        <td><?= $row['status'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">No attendance records found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
