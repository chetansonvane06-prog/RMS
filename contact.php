<?php
$messageSent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    $to = "chetansonvane06@gmail.com";  
    $subject = "New Contact Message";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        $messageSent = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>]p;.,0i./
<meta charset="UTF-8">
<title>Contact Us</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#07175e,#445ecf);
    color:white;
}
.contact-box{
    margin-top:60px;
    background:#ffffff;
    color:#000;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}
.contact-info{
    background:#445ecf;
    color:white;
    padding:30px;
    border-radius:15px;
}
.btn-primary{
    width:100%;
}
footer{
    margin-top:50px;
    text-align:center;
    padding:15px;
    background:#000;
    color:white;
}
</style>
</head>

<body>

<div class="container">
<div class="row justify-content-center">
<div class="col-md-10 contact-box">
<div class="row">

<div class="col-md-5 contact-info">
<h3>Contact Information</h3>
<hr>
<p><b>Address:</b> RBNB College, Shrirampur</p>
<p><b>Email:</b> chetansonvane06@gmail.com</p>
<p><b>Phone:</b> +91 9527498343</p>
</div>

<div class="col-md-7">
<h3>Send Message</h3>

<?php if($messageSent): ?>
<div class="alert alert-success">
Message sent successfully!
</div>
<?php endif; ?>

<form method="post">
<div class="mb-3">
<label class="form-label">Your Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Your Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Your Message</label>
<textarea name="message" class="form-control" rows="5" required></textarea>
</div>

<button type="submit" class="btn btn-primary">Send Message</button>
<a href="index.html" class="btn btn-success mt-3 w-100">Back to Home</a>
</form>

</div>
</div>
</div>
</div>
</div>

<footer>
&copy; 2025 Final RESULT. All rights reserved.
</footer>

</body>
</html>