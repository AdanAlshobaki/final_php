<?php
session_start();
include "../vendor/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = $conn->query("
    SELECT e.First_name, e.Last_name 
    FROM users u 
    JOIN employess e ON e.id = u.employee_id 
    WHERE u.id = ".$_SESSION['user_id']
)->fetch_assoc();

if (!$user) {
    die("User not found. Please check your session user_id.");
}


// Dashboard data
$totalEmployees = $conn->query("SELECT COUNT(*) as total FROM employess")->fetch_assoc()['total'];
$totalDepartments = $conn->query("SELECT COUNT(*) as total FROM departments")->fetch_assoc()['total'];
$pendingLeaves = $conn->query("SELECT COUNT(*) as total FROM leaves WHERE status='pending'")->fetch_assoc()['total'];


$employeesByDept = $conn->query("SELECT d.name, COUNT(e.id) as count 
                                FROM departments d 
                                LEFT JOIN employess e ON e.department_id=d.id 
                                GROUP BY d.id")->fetch_all(MYSQLI_ASSOC);

$leavesType = $conn->query("SELECT type, COUNT(*) as count FROM leaves GROUP BY type")->fetch_all(MYSQLI_ASSOC);

// Simple report: Employees by department
$employeesList = $conn->query("
    SELECT d.name as dept_name, e.First_name, e.Last_name 
    FROM employess e 
    JOIN departments d ON e.department_id=d.id
    ORDER BY d.name, e.First_name
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
.sidebar { min-height: 100vh; }
.nav-link.active { background-color: #0d6efd; color: white !important; }
.card:hover { transform: translateY(-5px); transition: 0.3s; cursor: pointer; }
</style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <?php include "../includes/sidbar.php"; ?>

    <!-- Main Content -->
    <div class="col-md-10 p-4">

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Dashboard</a>
          <div class="d-flex ms-auto align-items-center">
<span class="me-3">Welcome, <?= htmlspecialchars($user['First_name'] . " " . $user['Last_name']) ?></span>
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </nav>

      <!-- Cards Section -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center shadow-sm p-3">
            <h5>Total Employees</h5>
            <h3><?= $totalEmployees ?></h3>
            <canvas id="employeesChart"></canvas>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm p-3">
            <h5>Total Departments</h5>
            <h3><?= $totalDepartments ?></h3>
            <canvas id="departmentsChart"></canvas>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm p-3">
            <h5>Pending Leaves</h5>
            <h3><?= $pendingLeaves ?></h3>
            <canvas id="leavesChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Simple Report: Employees by Department -->
      <h4>Employees by Department</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Department</th>
            <th>Employee Name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($employeesList as $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp['dept_name']) ?></td>
            <td><?= htmlspecialchars($emp['First_name']." ".$emp['Last_name']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<script>
// Employees Chart
const employeesCtx = document.getElementById('employeesChart').getContext('2d');
new Chart(employeesCtx, {
    type: 'pie',
    data: {
        labels: [<?php foreach($employeesByDept as $d){echo "'".$d['name']."',";} ?>],
        datasets: [{
            label: 'Employees per Department',
            data: [<?php foreach($employeesByDept as $d){echo $d['count'].",";} ?>],
            backgroundColor: ['#007bff','#28a745','#dc3545','#ffc107','#6c757d']
        }]
    }
});

// Departments Chart
const departmentsCtx = document.getElementById('departmentsChart').getContext('2d');
new Chart(departmentsCtx, {
    type: 'bar',
    data: {
        labels: [<?php foreach($employeesByDept as $d){echo "'".$d['name']."',";} ?>],
        datasets: [{
            label: 'Employees Count',
            data: [<?php foreach($employeesByDept as $d){echo $d['count'].",";} ?>],
            backgroundColor: '#17a2b8'
        }]
    }
});

// Leaves Chart
const leavesCtx = document.getElementById('leavesChart').getContext('2d');
new Chart(leavesCtx, {
    type: 'doughnut',
    data: {
        labels: [<?php foreach($leavesType as $l){echo "'".$l['type']."',";} ?>],
        datasets: [{
            label: 'Leaves Types',
            data: [<?php foreach($leavesType as $l){echo $l['count'].",";} ?>],
            backgroundColor: ['#ffc107','#dc3545','#28a745']
        }]
    }
});
</script>

</body>
</html>
