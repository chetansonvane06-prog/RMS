<?php
include 'connection.php';

if(isset($_POST['btn'])) {
    $seetNo = $_POST['seetNo'];
    $name = $_POST['name'];
    $mother = $_POST['mother'];
    $prn = $_POST['prn'];
    $eligibity = $_POST['eligibity'];
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $class = $_POST['class'];
    $examination = $_POST['examination'];
    $date = $_POST['date'];

    $sql = "INSERT INTO admin(seatNo,Name,motherName,PRN,eligibilityNo,Major,Minor,Class,Examination,exam_date) 
            VALUES('$seetNo','$name','$mother','$prn','$eligibity','$major','$minor','$class','$examination','$date')";

    $result = mysqli_query($conn, $sql);

    if($result) {
        header('location:display.php');
    }
    $sq = "INSERT INTO admin(Class,Examination,exam_date) 
            VALUES('$class','$examination','$date')";

    mysqli_query($conn, $sq);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Student Information Form</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
    from {opacity:0;}
    to {opacity:1;}
}

.form-container {
    background: linear-gradient(135deg, #4e73df, #224abe);
    padding: 35px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    color: #fff;
    width: 100%;
    max-width: 600px;
    animation: slideUp 0.8s ease;
}

@keyframes slideUp {
    from {opacity:0; transform: translateY(50px);}
    to {opacity:1; transform: translateY(0);}
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
    text-shadow: 0 3px 10px rgba(0,0,0,0.4);
}

.form-control {
    border-radius: 12px;
    border: none;
    padding: 12px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: 0 0 10px rgba(255,255,255,0.7);
    outline: none;
}

.btn-primary {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
}

.back-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #fff;
    color: #224abe;
    font-weight: 600;
    border-radius: 25px;
    padding: 8px 20px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
}

.back-btn:hover {
    background: #f0f0f0;
    transform: translateX(-5px);
}
</style>
</head>

<body>

<a href="display.php" class="back-btn">⬅ Back</a>

<div class="form-container">
    <h2>Student Information Form</h2>
    <form method="post" action="#">
        <input type="int" name="seetNo" class="form-control" placeholder="1. Seat No." required autocomplete="off">
        <input type="text" name="name" class="form-control" placeholder="2. Name" required autocomplete="off">
        <input type="text" name="mother" class="form-control" placeholder="3. Mother Name" required autocomplete="off">
        <input type="text" name="class" class="form-control" placeholder="4. Class." required autocomplete="off">
        <input type="int" name="prn" class="form-control" placeholder="5. PRN" required autocomplete="off">
        <input type="int" name="eligibity" class="form-control" placeholder="6. Eligibility No." required autocomplete="off">
        <input type="text" name="major" class="form-control" placeholder="7. Major" required autocomplete="off">
        <input type="text" name="minor" class="form-control" placeholder="8. Minor" required autocomplete="off">
        <input type="text" name="examination" class="form-control" placeholder="9. Examination." required autocomplete="off">
        <input type="date" name="date" class="form-control" placeholder="9. Date." required autocomplete="off">
        <button type="submit" name="btn" class="btn btn-primary w-100">Submit</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>