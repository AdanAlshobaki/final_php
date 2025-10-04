<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$leaves = $conn->query("
    SELECT l.id, e.first_name, e.last_name, l.start_date, l.end_date, l.type, l.status 
    FROM leaves l
    JOIN employess e ON l.employee_id = e.id 
    WHERE l.status='pending'
");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_id = $_POST['leave_id'];
    $status   = $_POST['status'];
    $stmt = $conn->prepare("UPDATE leaves SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $leave_id);
    $stmt->execute();
    header("Location: manage_leaves.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Leaves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">HR System</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Pending Leave Requests</h2>

    <table class="table table-bordered table-striped table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Employee</th>
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($leaves->num_rows > 0): ?>
                <?php while($row = $leaves->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['start_date']) ?></td>
                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                    <td><?= htmlspecialchars($row['type']) ?></td>
                    <td>
                        <form method="post" class="d-flex gap-2">
                            <input type="hidden" name="leave_id" value="<?= $row['id'] ?>">
                            <button name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
                            <button name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No pending leaves</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
