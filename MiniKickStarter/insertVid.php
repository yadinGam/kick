<html lang=''>
<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>MyKick - New Project - Step 1</title>
</head>
<body>


<?php
echo
	'<nav class="navbar navbar-default">' .
	'<nav class="navbar navbar-inverse navbar-fixed-top">' .
	'<div class="col-md-5 col-md-offset-4">' .
	'<br><br>' .
	'<h1 class="registration_h2">Welcome ' . $_COOKIE['username'] . '!</h1>' .
	'<a role="button" class="btn btn-warning pull-right my_btn" href="logout.php">Log Out</a>' .
	'<a role="button" class="btn btn-success pull-right my_btn" href="main.php">Home</a><br>' .
	'<h3 class="registration_h2"><small>User type: ';
if ($_COOKIE['usertype'] == 'project_man') {
	echo 'project manager'. '</small></h3>';
}
else {
	echo $_COOKIE['usertype']. '</small></h3>';
}
echo
	'<br><br><br>' .
	'</div>' .
	'</nav>' .
	'<br><br><br><br><br><br><br>' .
	'<div class="container-fluid">' .
	'<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">' .
	'<ul class="nav navbar-nav navbar-">';
if ($_COOKIE['usertype'] == 'project_man') {
	echo
		'<li><a href="donation.php">Donate</a></li>' .
		'<li><a href="donerList.php">Watch donors</a></li>' .
		'<li><a href="projectMaintaince.php">Edit projects</a></li>' .
		'<li><a href="deletion.php">Delete a project</a></li>' ;
}
elseif ($_COOKIE['usertype'] == 'doner') {
	echo
	'<li><a href="donation.php">Donate</a></li>' ;
}
elseif ($_COOKIE['usertype'] == 'admin') {
	echo
		'<li><a href="donerList.php">Watch donors</a></li>' .
		'<li><a href="projectMaintaince.php">Edit projects</a></li>' .
		'<li><a href="deletion.php">Delete a project</a></li>' ;
}
echo
	'</ul>'  .
	'</div>' .
	'</div>' .
	'</nav>' .
	'<br>';
?>
<div class="container">
	<div id="projectFormDiv" class="container col-md-6 col-md-offset-3">
		<h1>Step 3:</h1>
		<h2>Choose a video</h2>
		<form method="POST" enctype="multipart/form-data" class="form-group">
			<span class="btn btn-info btn-file">
				Browse <input type ="file" name ="file">
			</span>
			<input value="upload" type="submit" name="upload" class="btn btn-success">
		</form>



<?php
session_start();
$project_name = $_SESSION['project_name'];
$project_id =  $_SESSION['project_id'];
				




if (isset ($_POST['upload'])) {
	$name = $_FILES['file']['name'];
	$tmp_name = $_FILES['file']['tmp_name'];
	move_uploaded_file($tmp_name, "C:\wamp\www\m\pic\\" . $name);
	$url = 'http://localhost/m/pic/' . $name;

	$con = new mysqli("localhost", "root", "", "final_project_db");
	$query = "SELECT * FROM `video` WHERE `project_id`='$project_id'";
	$result = mysqli_query($con, $query) or die(mysqli_error($con));
	if ($row = mysqli_fetch_array($result) >= 1) {
		echo "there already is pic for this project";
			header("location:main.php");
	} else {

		$result = $con->query("INSERT INTO video (name,url, project_name,project_id) VALUES ('$name','$url', '$project_name','$project_id')");

		if (isset ($_POST['upload'])) {
			echo '<br/>' . $name . ' has been uploaded';
			$con = new mysqli("localhost", "root", "", "final_project_db");
			$query = "SELECT * FROM `video` WHERE `project_id`='project_id'";
			$result = mysqli_query($con, $query) or die(mysqli_error($con));
			while ($row = mysqli_fetch_array($result)) {
				$_SESSION['id'] = $row['id'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['url'] = $row['url'];
				$_SESSION['project_name'] = $row['project_name'];
				$_SESSION['project_id'] = $row['project_id'];
				$id = $_SESSION['id'];
			}
			header("location:main.php");
//			echo '<br/>' . $_SESSION['id'] . '<br/>' . $_SESSION['name'] . '<br/>' . $_SESSION['url'] . '<br/>' . $_SESSION['project_name'];
			//echo '<div><a href = "watch.php?id=' . $id . '">' . $_SESSION['name'] . '</a></div>';
		} else {
			echo 'Something went wrong';
		}
	}
}
?>
</body>

