<?php
include 'connection.php';

if (isset($_GET['seatno'])) 
{
    $seatno = $_GET['seatno'];

    $sql = "SELECT * FROM admin WHERE seatNo='$seatno'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) 
    {
        $seetno = $row['seatNo'];
        $name = $row['Name'];
        $mother = $row['motherName'];
        $prn = $row['PRN'];
        $eligibility = $row['eligibilityNo'];
        $major = $row['Major'];
        $minor = $row['Minor'];
        $class = $row['Class'];
        $examination = $row['Examination'];
        $date = $row['exam_date'];
    } 
    else 
    {
        echo "<p class='text-danger text-center mt-5'>❌ Student Not Found!</p>";
        exit;
    }
} 
else 
{
    echo "<p class='text-danger text-center mt-5'>❌ Seat No not provided!</p>";
    exit;
}

$subjects = [];
$total_credits = 0;
$total_cp = 0;
$overall_result = "PASS";

$sql_sub = "SELECT * FROM subject WHERE seatNo='$seatno'";
$result_sub = mysqli_query($conn, $sql_sub);

if($result_sub && mysqli_num_rows($result_sub) > 0)
{
    while($row = mysqli_fetch_assoc($result_sub))
    {
        $cia = $row['CIA'];
        $ese = $row['ESE'];
        $total = $cia + $ese;
        $credits = $row['Credits'];

        // Grade & GP
        if($total>=45){ $grd="O"; $gp=10; }
        else if($total>=40){ $grd="A+"; $gp=9; }
        else if($total>=35){ $grd="A"; $gp=8; }
        else if($total>=30){ $grd="B+"; $gp=7; }
        else if($total>=25){ $grd="B"; $gp=6; }
        else if($total>=20){ $grd="C"; $gp=5; }
        else if($total>=15){ $grd="P"; $gp=4; }
        else{ $grd="F"; $gp=0; }

        $cp = $gp * $credits;

        if($gp == 0){ $overall_result = "FAIL"; }

        $total_credits += $credits;
        $total_cp += $cp;

        $subjects[] = [
            'sem'=>$row['sem'],
            'subCode'=>$row['subCode'],
            'subject'=>$row['subject'],
            'CIA'=>$cia,
            'ESE'=>$ese,
            'Total'=>$total,
            'Credits'=>$credits,
            'Grd'=>$grd,
            'GP'=>$gp,
            'CP'=>$cp
        ];
    }
}

// SGPA & CGPA
$sgpa = ($total_credits>0) ? $total_cp / $total_credits : 0;
$sgpa = number_format($sgpa,2);
$cgpa = $sgpa; 
$credit_earned = $total_credits; 
$credit_points = $total_cp;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Result Sheet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.college-logo{max-width:120px;height:auto;}
.principal-sign{max-width:100px;height:auto;}
table th, table td{text-align:center;font-size:14px;}
@media (max-width:576px){h1{font-size:18px;}h2,h3{font-size:14px;}}
@media print{.button{display:none;}}
</style>
</head>
<body class="bg-light">

<div class="container my-4 p-4 border border-3 border-primary bg-white rounded shadow">

  <div class="row text-center align-items-center border-bottom border-2 border-primary pb-3 mb-3">
    <div class="col-12 col-md-2 mb-3 mb-md-0">
      <img src="img/rbnb_logo.jpg.png" alt="College Logo" class="college-logo">
    </div>
    <div class="col-12 col-md-8">
      <h2 class="mb-1">Rayat Shikshan Sanstha's</h2>
      <h1 class="h4 fw-bold mb-1">R. B. Narayanrao Borawake College, Shrirampur</h1>
      <h3 class="h6 mb-1">Dist. Ahmednagar 413 709</h3>
      <h2 class="h6 mb-1">(Autonomous)</h2>
      <h3 class="h6 mb-1">Affiliated to Savitribai Phule Pune University, Pune</h3>
      <h3 class="h6 mb-1">AISHE Code: C-41688, College Code: 0022</h3>
    </div>
    <div class="col-12 col-md-2">
      <img src="img/university_logo.png" alt="University Logo" class="college-logo">
    </div>
  </div>

  <div class="border p-3 mb-3">
    <p class="mb-1">STATEMENT OF MARKS/GRADE SHEET FOR: <b><?php echo $class; ?></b></p>
    <p class="mb-0"><b>Examination :</b> <?php echo $examination; ?> As Per NEP-2020 (2023 Pattern)</p>
  </div>

  <div class="border p-3 mb-3">
    <div class="row">
      <div class="col-md-6"><b>Seat No:</b> <?php echo $seetno; ?></div>
      <div class="col-md-6"><b>Exam Center No:</b> 0022</div>
    </div>
    <div class="row">
      <div class="col-md-6"><b>Name:</b> <?php echo $name; ?></div>
      <div class="col-md-6"><b>Mother Name:</b> <?php echo $mother; ?></div>
    </div>
    <div class="row">
      <div class="col-md-6"><b>PRN:</b> <?php echo $prn; ?></div>
      <div class="col-md-6"><b>Eligibility No:</b> <?php echo $eligibility; ?></div>
    </div>
  </div>

  <div class="border p-3 mb-3">
    <div class="row">
      <div class="col-md-6"><b>Major:</b> <?php echo $major; ?></div>
      <div class="col-md-6"><b>Minor:</b> <?php echo $minor; ?></div>
    </div>
  </div>

  <div class="table-responsive border mb-3">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-primary">
        <tr>
          <th>Sem</th>
          <th>Sub. Code</th>
          <th>Subject</th>
          <th>CIA</th>
          <th>ESE</th>
          <th>Total</th>
          <th>Credits</th>
          <th>Grd.</th>
          <th>GP</th>
          <th>CP</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(!empty($subjects))
        {
            foreach($subjects as $sub)
            {
                echo "<tr>
                        <td>".$sub['sem']."</td>
                        <td>".$sub['subCode']."</td>
                        <td>".$sub['subject']."</td>
                        <td>".$sub['CIA']."</td>
                        <td>".$sub['ESE']."</td>
                        <td>".$sub['Total']."</td>
                        <td>".$sub['Credits']."</td>
                        <td>".$sub['Grd']."</td>
                        <td>".$sub['GP']."</td>
                        <td>".$sub['CP']."</td>
                      </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='10' class='text-danger'>❌ Subjects Not Found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="border p-3">
    <p class="mb-1">
      <b>SGPA:</b>  <?php echo $sgpa; ?>  |
      <b>Result:</b> <?php  echo $overall_result; ?>  |
      <b>Credit earned:</b>  <?php echo $credit_earned; ?>  |
      <b>Credit Points: </b> <?php echo $credit_points; ?>  |
      <b>CGPA: </b> <?php echo $cgpa; ?>
    </p>
    <div class="text-end">
      <img src="img/principal.jpg" alt="Principal Sign" class="principal-sign">
    </div>
    <p class="mt-2 mb-0">
      <b>Date:</b> <?php echo $date; ?> |
      <b>Medium of Instruction:</b> English
    </p>
  </div>

</div>

<div class="button text-center my-3">
  <a href="index.html" class="btn btn-primary" style="border-radius:20px; border-bottom:3px solid black; border-right:2px solid black;">Home</a>
  <button class="btn btn-primary" onclick="window.print()">🖨 Print Result</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>