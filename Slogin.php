<?php
include 'connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM admin WHERE motherName='$username' AND seatNo='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) 
      {
        $row = mysqli_fetch_assoc($result); 
        $seatno = $row['seatNo'];

        header("Location: result.php?seatno=$seatno");
        exit;
    } 
    else 
    {
        $message = "❌ Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
  <meta charset="UTF-8" />
  <title>Student Login</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('img/college.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      margin: 0;
    }
    input::placeholder {
      color: #999;
      font-style: italic;
    }
    .login-box {
      background-color: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
    label, h2 {
      color: white;
    }
    .form-control {
      background-color: rgba(255, 255, 255, 0.6);
      border: none;
    }
    .form-control:focus {
      box-shadow: none;
    }
    hr {
      border-color: rgba(255, 255, 255, 0.5);
    }
  </style>
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-4 p-5 login-box">
        <h2 class="text-center mb-4">👨‍🎓 Student Login</h2>

      <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
      <?php endif; ?>

      <form action="" method="post">
        <div class="mb-3">
          <label class="form-label">Mother Name</label>
          <input type="text" class="form-control" name="username" autocomplete="off" id="username" placeholder="MotherName" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Seat Number</label>
          <input type="text" class="form-control" id="password" name="password" autocomplete="off" placeholder="SeatNo" required />
        </div>

        <div class="d-flex justify-content-between mt-4">
          <button type="reset" class="btn btn-secondary" onclick="window.open('index.html');">Cancel</button>
          <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <hr class="my-4" />
        <div class="text-center">
          <button type="button" class="btn btn-outline-danger w-100" onclick="window.open('https://www.instagram.com/chetan_sonvane1411','_blank');">
            <i class="fab fa-instagram me-2" style="color: blue;"></i> <span style="color: white;">Instagram</span>
          </button>
        </div>
      </form>
      </div>
  </div>
</body>
</html>