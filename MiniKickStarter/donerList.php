<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
   <title>MyKick - Watch Donors</title>
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
		'<li><a href="projectMaintaince.php">Edit projects</a></li>' .
		'<li><a href="projectForm.php">Add a project</a></li>' .
		'<li><a href="deletion.php">Delete a project</a></li>' ;
}
elseif ($_COOKIE['usertype'] == 'doner') {
	echo
		'<li><a href="donation.php">Donate</a></li>' ;
}
elseif ($_COOKIE['usertype'] == 'admin') {
	echo
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


<div class="container col-md-6 col-md-offset-3">
<?php
session_start();
$userid = $_SESSION['userid'];

$usertype = $_SESSION['usertype'];
projectOfManager($userid);

if (isset ($_POST['submit']) && $_POST['mySelect'] != "Select") {
	//$project_name = $_POST['mySelect'];
	$project_id = $_POST['mySelect'];
	ShowDonersIfExist($project_id);
} else {
		echo '<h3 class = "donerlist_alert">You must make your selection!</h3>';
}

function projectOfManager($userid) {
	$con = new mysqli("localhost", "root", "", "final_project_db");

	$usertype = $_SESSION['usertype'];
	if ($usertype == 'admin') {
		$result = $con->query("SELECT * FROM project");
	} else {
		$result = $con->query("SELECT * FROM project WHERE user_id = '$userid'");
	}
	$num_of_projects = mysqli_num_rows($result);

	if ($num_of_projects == 0) {
		echo '<h3>You have no projects,<br>Create one and try again!</h3>';
	} else {
		showProjects($result);
	}
	mysqli_close($con);
}

function showProjects($result) {
	$username = $_SESSION['username'];
	
	if (isset ($_POST['submit'])) {
		$selection = $_SESSION['project_name'];
	} else {
		$selection = "Select";
	}

	echo '<h2>Dear ' . $username . ',<br> Choose a project to watch donors:</h2>
<form method ="POST" class="form-group col-md-3">
<select name = "mySelect" class="form-control">';
	echo '<option value=' . $selection . '>' . $selection . '</option>';
	while (($row = mysqli_fetch_array($result))) {
		if ($row['project_name'] != $selection) {
			$_SESSION['project_name']=$row['project_name'];
			echo '<option value=' . $row['project_id'] . '>' . $row['project_name'] . ' </option>';
		}
	}
	echo '</select><br>
<input value="Watch" type="submit" name="submit" class="btn btn-success">
</form>';
}

function ShowDonersIfExist($project_id) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("SELECT * FROM doner WHERE project_id = '$project_id'");
	$num_of_projects = mysqli_num_rows($result);

	if ($num_of_projects == 0) {
		echo '</br>there are no donors for this project';
	} else {
		showDoners($result);
	}
	mysqli_close($con);
}

function showDoners($result) {
	echo '<table class="table table-bordered">' . '<tr class = "table_header">' . '<td>' . 'Donor Name' . '</td>' . '<td>' . 'Project Name' . '</td>' . '<td>' . 'Amount Donated' . '</td>' . '</tr>';
	while (($row = mysqli_fetch_array($result))) {
		echo '<tr>' . '<td>' . $row['doner_name'] . '</td>' . '<td>' . $row['project_name'] . '</td>' . '<td>' . $row['amount'] . '</td>' . '</tr>';
	}
	echo '</table>';
}

?>
</div>
</body>
</html>