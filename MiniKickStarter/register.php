<?php

session_start();


$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$usertype = $_POST['usertype'];

echo $password1. $password2;

if ($password1 != $password2){  
	header('Location: registration.php?notify= passwords does not match');}

else if (strlen($username) > 30){ 
	header('Location: registration.php?notify= invailed user name');}
	
else{$password = md5($password1);

$mysqli = new mysqli('localhost', 'root', '', 'final_project_db');

//sanitize username
$username = $mysqli->real_escape_string($username);

$result = $mysqli->query("SELECT * FROM final_project_db.users WHERE username='$username'");

if ($result->num_rows >= 1) {
	header("location:registration.php?notify=User already exists ");
} else {
	$query = "INSERT INTO final_project_db.users ( username, password, usertype ,email ) VALUES ( '$username', '$password','$usertype','$email')";
	$mysqli->query($query);
	$mysqli->close();
	header("Location:main.php?notify= Thank you for registration");
}}



?>