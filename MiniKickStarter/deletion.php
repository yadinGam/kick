<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
   <title>MyKick - Delete projects</title>
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
		'<li><a href="projectForm.php">Add a project</a></li>' ;
}
elseif ($_COOKIE['usertype'] == 'doner') {
	echo
	'<li><a href="donation.php">Donate</a></li>' ;
}
elseif ($_COOKIE['usertype'] == 'admin') {
	echo
		'<li><a href="donerList.php">Watch donors</a></li>' .
		'<li><a href="projectMaintaince.php">Edit projects</a></li>' ;

}
echo
	'</ul>'  .
	'</div>' .
	'</div>' .
	'</nav>' .
	'<br>';
?>

<div class="container col-md-4 col-md-offset-4">

<h2>Choose a project to delete</h2><br>
<form method ="POST" class="form-group col-md-4">

<?php
session_start();

if(isset($_COOKIE['userid'])){
$user_id =$_SESSION['userid'];	
}else{$user_id =$_SESSION['userid'];}

$doner_type = $_SESSION['usertype'];

pick_a_project($user_id);

function pick_a_project($user_id) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	
	$usertype = $_SESSION['usertype'];
	
	if($usertype=='admin'){
	$result = $con->query("SELECT * FROM project");
	}else if($usertype=='project_man'){
			$result = $con->query("SELECT * FROM project WHERE user_id = '$user_id'");
	}
	

if(mysqli_num_rows($result)!=0){
	echo '<select name = "mySelect" class="form-control">';
	while ($row = mysqli_fetch_array($result)) {
		
		$pid = $row['project_id'];
		
		echo '<option value=  ' . $pid . '>' .$row['project_name']. '</option>';
	}echo '</select>';
	
echo '		<br>
<input value="Delete" type="submit" name="Delete" class="btn btn-danger">
</form>';
	
	
}else{echo  '<div class = "deletion_alert"><a> no projects</a></div>';}
	mysqli_close($con);
}


//function deleteProject($project_name) {
//	$con = new mysqli("localhost", "root", "", "final_project_db");
//	$query = "DELETE FROM project WHERE project_name = '$project_name'";
//	$result = mysqli_query($con, $query);
//	
//	deleteDonors($project_name);
//	
//	mysqli_close($con);
//}

function deleteProject($pid) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$query = "DELETE FROM project WHERE project_id = '$pid'";
	$result = mysqli_query($con, $query);
	
	deleteDonors($pid);
	deletePic($pid);
	deleteVid($pid);
	
	mysqli_close($con);
}

//function deleteDonors($project_name){
//		$con = new mysqli("localhost", "root", "", "final_project_db");
//	$query = "DELETE FROM doner WHERE project_name = '$project_name'";
//	$result = mysqli_query($con, $query);
//	mysqli_close($con);
//}

function deleteDonors($pid){
		$con = new mysqli("localhost", "root", "", "final_project_db");
	$query = "DELETE FROM doner WHERE project_id = '$pid'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
}

function deletePic($pid){
		$con = new mysqli("localhost", "root", "", "final_project_db");
	$query = "DELETE FROM images WHERE project_id = '$pid'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
}
function deleteVid($pid){
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$query = "DELETE FROM video WHERE project_id = '$pid'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);
}
?>


<div>
<p>


<?php

if (isset ($_POST['Delete'])) {
	
	$pid = $_POST['mySelect'];
	
	echo '<p>you selected to delete project no.'.$pid.' </p>';
		$con = new mysqli("localhost", "root", "", "final_project_db");
			$result = $con->query("SELECT `project_name` FROM `project` WHERE `project_id`= '$pid'");
					 $row = mysqli_fetch_array($result);
				$project_name =  $row['project_name'];
				
				mysqli_close($con);
	
	//deleteProject($project_name);
	deleteProject($pid);
	
	echo $pid.' deleted '; 
	echo $project_name.' deleted';
}
?>
</p>
</div>
</div>
</body>
</html>


