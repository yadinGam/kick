


<!doctype html>
<html lang=''>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
   <title>KIKI - Members </title>
</head>
<body>
<div class='divtoolbar'>
<?php
session_start();
if(isset($_COOKIE['username'])){
	$username = $_COOKIE['username'];
}else{$username =$_SESSION['username'];}

if(isset($_COOKIE['usertype'])){
	$_SESSION['usertype'] = $_COOKIE['usertype'];
	echo "".$_SESSION['usertype'];
}


 
if (isset($_SESSION['usertype'])) {
	echo $_GET['notify'];
if($_SESSION['usertype']=="admin") {
header("location:admin.html");}
else if($_SESSION['usertype']=="doner") {header("location:donor.html");}
else if ($_SESSION['usertype']=="project_man") {header("location:projectManager.html");}
}else{echo "<br/>something is wrong with the type of user";}
?>
</body>
<html>
