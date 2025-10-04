<?php

session_start();
include "../vendor/config.php";

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// تاريخ اليوم
$today = date('Y-m-d');

// جلب كل الموظفين
$employees = $conn->query("SELECT id, First_name, Last_name FROM employess");

// حفظ الحضور عند الضغط على زر Submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['attendance'])) {
    foreach ($_POST['attendance'] as $emp_id => $status) {
        // التحقق إذا سجل الحضور اليوم أصلاً
        $check = $conn->prepare("SELECT id FROM attendance WHERE employee_id=? AND attendance_date=?");
        $check->bind_param("is", $emp_id, $today);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            // تحديث إذا موجود
            $stmt = $conn->prepare("UPDATE attendance SET status=? WHERE employee_id=? AND attendance_date=?");
            $stmt->bind_param("sis", $status, $emp_id, $today);
        } else {
            // إدخال جديد
            $stmt = $conn->prepare("INSERT INTO attendance (employee_id, attendance_date, status) VALUES (?,?,?)");
            $stmt->bind_param("iss", $emp_id, $today, $status);
        }
        $stmt->execute();
    }
    $success = "Attendance saved successfully!";
}

// جلب بيانات الحضور لعرضها في الجدول
$attendanceData = $conn->query("
    SELECT e.id, e.First_name, e.Last_name, 
           IFNULL(a.status, 'Absent') AS status
    FROM employess e
    LEFT JOIN attendance a 
    ON e.id = a.employee_id AND a.attendance_date='$today'
    ORDER BY e.id ASC
");


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daily Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Daily Attendance (<?= $today ?>)</h2>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <form method="post">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $attendanceData->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['First_name'] . " " . $row['Last_name'] ?></td>
          <td>
            <select name="attendance[<?= $row['id'] ?>]" class="form-select">
              <option value="Present" <?= ($row['status'] == 'Present') ? 'selected' : '' ?>>Present</option>
              <option value="Absent" <?= ($row['status'] == 'Absent') ? 'selected' : '' ?>>Absent</option>
            </select>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Save Attendance</button>
  </form>
</div>
</body>
</html>
