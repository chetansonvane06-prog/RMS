<?php
include 'connection.php';

if (!isset($_GET['seatNo']) || $_GET['seatNo']=="") {
    die("Unauthorized Access");
}
$seatNo = $_GET['seatNo'];

$filterSem = $_GET['sem'] ?? "";

/* ===== DELETE ===== */
if (isset($_GET['delete'])) {
    $subId = $_GET['delete'];
    mysqli_query($conn,
        "DELETE FROM subject 
         WHERE subId='$subId' AND seatNo='$seatNo'"
    );
    header("Location: subject.php?seatNo=$seatNo&sem=$filterSem");
    exit();
}

/* ===== INSERT ===== */
if (isset($_POST['submit'])) {
    mysqli_query($conn,
        "INSERT INTO subject(seatNo, sem, subject, subCode, CIA, ESE, Credits)
         VALUES(
            '$seatNo',
            '$_POST[sem]',
            '$_POST[subject]',
            '$_POST[subCode]',
            '$_POST[CIA]',
            '$_POST[ESE]',
            '$_POST[Credits]'
         )"
    );
    header("Location: subject.php?seatNo=$seatNo&sem=$_POST[sem]");
    exit();
}

$sql = "SELECT * FROM subject WHERE seatNo='$seatNo'";
if ($filterSem!="") $sql .= " AND sem='$filterSem'";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Subject Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
  color:white;
  animation:fadeIn 1s ease;
}
@keyframes fadeIn{
  from{opacity:0}to{opacity:1}
}

.card{
  animation:slideUp .8s ease;
  border-radius:15px;
}
@keyframes slideUp{
  from{transform:translateY(40px);opacity:0}
  to{transform:translateY(0);opacity:1}
}

.table{
  animation:zoom .8s ease;
}
@keyframes zoom{
  from{transform:scale(.95);opacity:0}
  to{transform:scale(1);opacity:1}
}

.btn{
  transition:.3s;
}
.btn:hover{
  transform:scale(1.08);
}

h4 span{
  color:#ffc107;
}
</style>
</head>

<body>
<div class="container mt-4">

<h4 class="text-center mb-4 fw-bold">
🔒 Seat No <span><?= $seatNo ?></span> – Only Your Records
<a href="display.php" class="btn btn-warning btn-sm ms-3">⬅ Back</a>
</h4>

<form method="get" class="mb-3">
<input type="hidden" name="seatNo" value="<?= $seatNo ?>">
<div class="row g-2 justify-content-center">
<div class="col-md-3">
<select name="sem" class="form-select">
<option value="">All Semester</option>
<?php for($i=1;$i<=6;$i++){ ?>
<option value="<?= $i ?>" <?= ($filterSem==$i)?"selected":"" ?>>Sem <?= $i ?></option>
<?php } ?>
</select>
</div>
<div class="col-md-2">
<button class="btn btn-info w-100">Filter</button>
</div>
</div>
</form>

<div class="card p-3 mb-4">
<h5 class="text-center mb-3">➕ Add Subject</h5>
<form method="post">
<div class="row g-2">
<div class="col-md-2">
<input class="form-control" value="Seat <?= $seatNo ?>" readonly>
</div>
<div class="col-md-1">
<input name="sem" class="form-control" placeholder="Sem" required>
</div>
<div class="col-md-3">
<input name="subject" class="form-control" placeholder="Subject" required>
</div>
<div class="col-md-2">
<input name="subCode" class="form-control" placeholder="Code" required>
</div>
<div class="col-md-1">
<input name="CIA" type="number" class="form-control" placeholder="CIA" required>
</div>
<div class="col-md-1">
<input name="ESE" type="number" class="form-control" placeholder="ESE" required>
</div>
<div class="col-md-1">
<input name="Credits" type="number" class="form-control" placeholder="Cr" required>
</div>
<div class="col-md-1">
<button name="submit" class="btn btn-success w-100">Save</button>
</div>
</div>
</form>
</div>

<table class="table table-bordered table-hover bg-white text-center">
<thead class="table-dark">
<tr>
<th>Sem</th><th>Subject</th><th>Code</th>
<th>CIA</th><th>ESE</th><th>Total</th>
<th>Grade</th><th>GP</th><th>CP</th><th>Action</th>
</tr>
</thead>
<tbody>

<?php
if(mysqli_num_rows($result)>0){
while($row=mysqli_fetch_assoc($result)){
$total=$row['CIA']+$row['ESE'];

if($total>=45){$g="O";$gp=10;}
elseif($total>=40){$g="A+";$gp=9;}
elseif($total>=35){$g="A";$gp=8;}
elseif($total>=30){$g="B+";$gp=7;}
elseif($total>=25){$g="B";$gp=6;}
elseif($total>=20){$g="C";$gp=5;}
elseif($total>=15){$g="P";$gp=4;}
else{$g="F";$gp=0;}

$cp=$gp*$row['Credits'];

echo "<tr>
<td>{$row['sem']}</td>
<td>{$row['subject']}</td>
<td>{$row['subCode']}</td>
<td>{$row['CIA']}</td>
<td>{$row['ESE']}</td>
<td>$total</td>
<td>$g</td>
<td>$gp</td>
<td>$cp</td>
<td>
<a class='btn btn-danger btn-sm'
href='subject.php?seatNo=$seatNo&sem=$filterSem&delete={$row['subId']}'
onclick=\"return confirm('Delete this record?')\">Delete</a>
</td>
</tr>";
}}
else{
echo "<tr><td colspan='10'>No Records Found</td></tr>";
}
?>

</tbody>
</table>

</div>
</body>
</html>