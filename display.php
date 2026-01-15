<?php
include 'connection.php';

if (isset($_GET['deleteid'])) {
    $seatno = $_GET['deleteid'];
    mysqli_query($conn, "DELETE FROM admin WHERE seatNo='$seatno'");
    header("Location: display.php");
    exit();
}

$updateMode = false;
$seatno = "";
$name = $mother = $prn = $eligibility = $major = $minor = "";

if (isset($_GET['updateid'])) {
    $updateMode = true;
    $seatno = $_GET['updateid'];
    $row = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM admin WHERE seatNo='$seatno'")
    );

    $name = $row['Name'];
    $mother = $row['motherName'];
    $prn = $row['PRN'];
    $eligibility = $row['eligibilityNo'];
    $major = $row['Major'];
    $minor = $row['Minor'];
}

if (isset($_POST['btn'])) {
    mysqli_query($conn, "UPDATE admin SET
        Name='$_POST[name]',
        motherName='$_POST[mother]',
        PRN='$_POST[prn]',
        eligibilityNo='$_POST[eligibility]',
        Major='$_POST[major]',
        Minor='$_POST[minor]'
        WHERE seatNo='$seatno'
    ");
    header("Location: display.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
  min-height:100vh;
  font-family:'Segoe UI',sans-serif;
  animation:fadeIn 1s ease;
}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
.top-bar{
  background:linear-gradient(135deg,#6610f2,#0d6efd);
  padding:15px 25px;
  border-radius:15px;
  box-shadow:0 10px 25px rgba(0,0,0,.4);
  animation:slideDown 1s ease;
}
@keyframes slideDown{
  from{opacity:0;transform:translateY(-30px)}
  to{opacity:1;transform:translateY(0)}
}
.back-btn{
  border-radius:25px;
  font-weight:600;
  transition:.3s;
}
.back-btn:hover{
  transform:translateX(-6px);
  box-shadow:0 6px 20px rgba(0,0,0,.4);
}

.action-btn{
  transition:.3s;
}
.action-btn:hover{
  transform:scale(1.08);
  box-shadow:0 8px 20px rgba(0,0,0,.4);
}
h1{
  color:#fff;
  font-weight:700;
  text-shadow:0 4px 10px rgba(0,0,0,.5);
}

.action-btn{
  transition:all .3s ease;
}
.action-btn:hover{
  transform:translateY(-3px) scale(1.05);
  box-shadow:0 10px 25px rgba(0,0,0,.5);
}

.form-container{
  max-width:600px;
  margin:30px auto;
  background:linear-gradient(135deg,#4e73df,#224abe);
  padding:30px;
  border-radius:15px;
  color:white;
  box-shadow:0 15px 30px rgba(0,0,0,.5);
  animation: slideUp .8s ease;
}
@keyframes slideUp{
  from{opacity:0;transform:translateY(40px)}
  to{opacity:1;transform:translateY(0)}
}

.form-control{
  border-radius:10px;
}

.table{
  border-radius:15px;
  overflow:hidden;
}

.table thead{
  background:linear-gradient(135deg,#0d6efd,#0a58ca);
  color:white;
}

.table tbody tr{
  transition:all .3s ease;
}
.table tbody tr:hover{
  background:#eef2ff;
  transform:scale(1.01);
}

.table td,.table th{
  vertical-align:middle;
}

.table-responsive{
  animation: fadeTable 1s ease;
}
@keyframes fadeTable{
  from{opacity:0;transform:scale(.97)}
  to{opacity:1;transform:scale(1)}
}
</style>
</head>

<body>
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-4 top-bar">
  <a href="index.html" class="btn btn-light back-btn">⬅ Back</a>
  <h3 class="text-white fw-bold m-0">Student Management System</h3>
</div>

<div class="d-flex justify-content-end mb-3">
  <a href="home.php" class="btn btn-success action-btn">
    + Add Student
  </a>
</div>

<!-- ===== UPDATE FORM ===== -->
<?php if($updateMode){ ?>
<div class="form-container">
<h3 class="text-center mb-3">Update Student</h3>
<form method="post">
<input class="form-control mb-2" name="name" value="<?= $name ?>" required>
<input class="form-control mb-2" name="mother" value="<?= $mother ?>" required>
<input class="form-control mb-2" name="prn" value="<?= $prn ?>" required>
<input class="form-control mb-2" name="eligibility" value="<?= $eligibility ?>" required>
<input class="form-control mb-2" name="major" value="<?= $major ?>" required>
<input class="form-control mb-3" name="minor" value="<?= $minor ?>" required>
<button name="btn" class="btn btn-success w-100">Update</button>
</form>
</div>
<?php } ?>

<!-- ===== STUDENT TABLE ===== -->
<div class="table-responsive">
<table class="table table-bordered table-hover bg-white text-center">
<thead>
<tr>
<th>Seat No</th>
<th>Name</th>
<th>Mother Name</th>
<th>PRN</th>
<th>Eligibility No</th>
<th>Major</th>
<th>Minor</th>
<th>Operation</th>
</tr>
</thead>
<tbody>
<?php
$result = mysqli_query($conn,"SELECT * FROM admin");
while($row = mysqli_fetch_assoc($result)){
echo "<tr>
<td>{$row['seatNo']}</td>
<td>{$row['Name']}</td>
<td>{$row['motherName']}</td>
<td>{$row['PRN']}</td>
<td>{$row['eligibilityNo']}</td>
<td>{$row['Major']}</td>
<td>{$row['Minor']}</td>
<td>
<a href='display.php?updateid={$row['seatNo']}'
   class='btn btn-warning btn-sm action-btn'>Update</a>

<a href='display.php?deleteid={$row['seatNo']}'
   class='btn btn-danger btn-sm action-btn'
   onclick=\"return confirm('Kya aap sure delete karna chahte hai?')\">Delete</a>

<a href='subject.php?seatNo=".$row['seatNo']."'
   class='btn btn-info btn-sm action-btn'>+ Subject</a>
</td>
</tr>";
}
?>
</tbody>
</table>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>