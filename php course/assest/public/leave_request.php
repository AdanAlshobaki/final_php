<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['employee_id']) || $_SESSION['employee_id'] === null) {
    die("Employee not found! check employee join with user");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['employee_id'];
    $leave_type  = $_POST['leave_type'];
    $start_date  = $_POST['start_date'];
    $end_date    = $_POST['end_date'];
    $reason      = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO leaves (employee_id, type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $employee_id, $leave_type, $start_date, $end_date, $reason);

    if ($stmt->execute()) {
        $success = "Leave request submitted successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Leave Request</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Leave Type</label>
            <select name="leave_type" class="form-control" required>
                <option value="annual">Annual</option>
                <option value="sick">Sick</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Reason</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
</body>
</html>
