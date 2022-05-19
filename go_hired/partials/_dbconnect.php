<?php
//script to conndct to database
$host='localhost';
$user='root';
$password='';
$db='gohired';

$con=mysqli_connect($host,$user,$password,$db);
if (!$con)
{
die('Could not connect: ' . mysqli_error($con));
}
else{
    // echo"<script>alert('database connection successful');</script>";
}
?>