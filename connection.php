<?php
    $conn=new mysqli("localhost","root","","Ra-One");
    if(!$conn)
    {
            die(mysqli_error($conn));
    }
?>