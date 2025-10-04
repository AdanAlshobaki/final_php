<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// dropdown to get employee
$employees = $conn->query("SELECT id, First_name, Last_name FROM employess");

// Default values ​​for month and year
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;

$attendanceData = [];

if ($employee_id > 0) {
    $stmt = $conn->prepare("SELECT attendance_date , status 
                            FROM attendance 
                            WHERE employee_id=? AND MONTH(attendance_date )=? AND YEAR(attendance_date )=?");
    $stmt->bind_param("iii", $employee_id, $month, $year);
    $stmt->execute();
    $attendanceData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
// Convert data to an easy-to-use array
$attendanceMap = [];
foreach ($attendanceData as $row) {
    $day = intval(date('d', strtotime($row['attendance_date'])));
    $attendanceMap[$day] = $row['status'];
}


// Number of days in the month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Monthly Attendance Report</h2>

    <form method="get" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <label>Employee:</label>
            <select name="employee_id" class="form-select" required>
                <option value="">-- Select Employee --</option>
                <?php while ($emp = $employees->fetch_assoc()): ?>
                    <option value="<?= $emp['id'] ?>" <?= ($emp['id']==$employee_id)?'selected':'' ?>>
                        <?= $emp['First_name'] . " " . $emp['Last_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-auto">
            <label>Month:</label>
            <input type="number" name="month" class="form-control" value="<?= $month ?>" min="1" max="12">
        </div>
        <div class="col-auto">
            <label>Year:</label>
            <input type="number" name="year" class="form-control" value="<?= $year ?>" min="2000" max="2100">
        </div>
        <div class="col-auto mt-4">
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </div>
    </form>

    <?php if ($employee_id > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>Day</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($d = 1; $d <= $daysInMonth; $d++): 
                $status = isset($attendanceMap[$d]) ? $attendanceMap[$d] : 'Absent';
            ?>
                <tr>
                    <td><?= $d ?></td>
                    <td><?= $status ?></td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
