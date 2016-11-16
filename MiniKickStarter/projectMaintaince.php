<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
   <title>MyKick - Edit Projects</title>
</head>
<body>

<?php
echo '<nav class="navbar navbar-default">' .
'<nav class="navbar navbar-inverse navbar-fixed-top">' .
'<div class="col-md-5 col-md-offset-4">' .
'<br><br>' .
'<h1 class="registration_h2">Welcome ' . $_COOKIE['username'] . '!</h1>' .
'<a role="button" class="btn btn-warning pull-right my_btn" href="logout.php">Log Out</a>' .
'<a role="button" class="btn btn-success pull-right my_btn" href="main.php">Home</a><br>' .
'<h3 class="registration_h2"><small>User type: ';
if ($_COOKIE['usertype'] == 'project_man') {
	echo 'project manager' . '</small></h3>';
} else {
	echo $_COOKIE['usertype'] . '</small></h3>';
}
echo '<br><br><br>' .
'</div>' .
'</nav>' .
'<br><br><br><br><br><br><br>' .
'<div class="container-fluid">' .
'<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">' .
'<ul class="nav navbar-nav navbar-">';
if ($_COOKIE['usertype'] == 'project_man') {
	echo '<li><a href="donation.php">Donate</a></li>' .
	'<li><a href="donerList.php">Watch donors</a></li>' .
	'<li><a href="projectForm.php">Add a project</a></li>' .
	'<li><a href="deletion.php">Delete a project</a></li>';
}
elseif ($_COOKIE['usertype'] == 'doner') {
	echo '<li><a href="donation.php">Donate</a></li>';
}
elseif ($_COOKIE['usertype'] == 'admin') {
	echo '<li><a href="donerList.php">Watch donors</a></li>' .
	'<li><a href="deletion.php">Delete a project</a></li>';
}
echo '</ul>' .
'</div>' .
'</div>' .
'</nav>' .
'<br>';
?>
<div class="container col-md-6 col-md-offset-3">
<?php


session_start();

$usertype = $_SESSION['usertype'];

if (isset ($_SESSION['userid'])) {
	$userid = $_SESSION['userid'];
} else {
	echo 'There is a problem with the user id - unable to retrieve it';
}

projectOfManager($userid);

function projectOfManager($userid) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$usertype = $_SESSION['usertype'];
	if ($usertype == 'admin') {
		$result = $con->query("SELECT * FROM project");
		//$row = mysqli_fetch_array($result);
	} else {
		$result = $con->query("SELECT * FROM project WHERE user_id = '$userid'");
	}

	$num_of_projects = mysqli_num_rows($result);
	if ($num_of_projects == 0) {
		echo '<h3>You have no projects,<br>Create one and try again!</h3>';
	} else {

		if (isset ($_POST['submit']) && $_POST['mySelect'] != "Select") {
			$project_id = $_POST['mySelect'];
			showProjectInfo($project_id);
		} else {
			echo '<h3 class = "donerlist_alert">You must make your selection!</h3>';
		}

		showProjects($result);

		if (isset ($_POST['edit'])) {
			$con = new mysqli("localhost", "root", "", "final_project_db");
			$pid = $_SESSION['pid'];
			if ($_POST['project_name'] != "") {
				$new_name = $_POST['project_name'];
				//$str = $str . ' ' . $new_name;
				echo '<div>' . $_SESSION['pid'] . ' ' . $new_name . '</div>';
				$result = $con->query("UPDATE project SET project_name='$new_name' WHERE project_id = $pid");
				// query for change in the doners list
				$result = $con->query("UPDATE doner SET project_name='$new_name' WHERE project_id = $pid");
			}
			if ($_POST['one_bid'] > 0) {
				$new_bid = $_POST['one_bid'];
				//$str = $str . ' ' . $new_bid;
				echo '<div>' . $new_bid . '</div>';
				$result = $con->query("UPDATE project SET one_bid='$new_bid' WHERE project_id = $pid");
			}
			if ($_POST['wanted_amount'] > 0) {
				$new_amount = $_POST['wanted_amount'];
				//$str = $str . ' ' . $new_amount;
				echo '<div>' . $new_amount . '</div>';
				$result = $con->query("UPDATE project SET wanted_amount='$new_amount' WHERE project_id = $pid");
			}
			if ($_POST['project_description'] != "") {
				$new_description = $_POST['project_description'];
				//$str = $str . ' ' . $new_description;
				echo '<div>' . $new_description . '</div>';
				$result = $con->query("UPDATE project SET project_description='$new_description' WHERE project_id = $pid");
			}
			if ($_POST['offer_description'] != "") {
				$new_odesc = $_POST['offer_description'];
				//$str = $str . ' ' . $new_odesc;
				echo '<div>' . $new_odesc . '</div>';
				$result = $con->query("UPDATE project SET offer_description='$new_odesc' WHERE project_id = $pid");
			}

		}
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
	//	while (($row = mysqli_fetch_array($result))) {
	//			echo $row['project_name'];
	//	}
	echo '<h2>Dear ' . $username . ',<br> Choose a project to edit:</h2>
										<form method ="POST" class="form-group col-md-3">
										<select name = "mySelect" class="form-control">';
	//echo '<option value=' . $selection . '>' . $selection . '</option>';
	echo '<option value=' . $selection . '>' . $selection . '</option>';
	while (($row = mysqli_fetch_array($result))) {
		if ($row['project_name'] != $selection) {
			$_SESSION['project_name'] = $row['project_name'];
			echo '<option value=' . $row['project_id'] . '>' . $row['project_name'] . ' </option>';
		}
	}
	echo '</select><br>
										<input value="Choose" type="submit" name="submit" class="btn btn-success">
										</form>';

}

function showProjectInfo($project_id) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("SELECT * FROM project WHERE project_id = '$project_id'");
	showFields($result);
	mysqli_close($con);
}

function showFields($result) {
	echo '<table class="table table-bordered">' . '<tr class = "table_header">' . '<td>' . 'Project ID' . '</td>' . '<td>' . 'User ID' . '</td>' . '<td>' . 'Project Name' . '</td>' . '<td>' . 'Minimum Donation' . '</td>' . '<td>' . 'Wanted Amount' . '</td>' . '<td>' . 'Project Description' . '</td>' . '<td>' . 'Offer Description' . '</td>' . '<td>' . 'Start Date' . '</td>' . '<td>' . 'Expiration Date' . '</td>';
	while (($row = mysqli_fetch_array($result))) {
		echo '<tr>' . '<td>' . $row[0] . '</td>' . '<td>' . $row[5] . '</td>' . '<td>' . $row[1] . '</td>' . '<td>' . $row[3] . '</td>' . '<td>' . $row[2] . '</td>' . '<td>' . $row[4] . '</td>' . '<td>' . $row[6] . '</td>' . '<td>' . $row[7] . '</td>' . '<td>' . $row[8] . '</td>' . '</tr>';
		$_SESSION['pid'] = $row[0];
	}
	echo '</table><br>';

	echo '<div class="container" >';
	editBox($result);
	echo '</div>';

}

function editBox($result) {

	echo '<h2>Editable attributes:</h2>';
	echo ' <form method ="POST" class="col-md-5">' .
	'<div class="form-group"><label for="project_name">Project name:</label>
				<input type="text" name="project_name" value="" class="form-control"></div>' .
	'<div class="form-group"><label for="one_bid">Minimum donation:</label>
				<input type="number" name="one_bid" value="" class="form-control"></div>' .
	'<div class="form-group"><label for="wanted_amount">Wanted amount:</label>
				<input  type="number" name="wanted_amount" value="" class="form-control"></div>' .
	'<div class="form-group"><label for="project_description">Project description:</label>
				<input type="text" name="project_description" value="" class="form-control"></div>' .
	'<div class="form-group"><label for="offer_description">Offer description:</label>
				<input type="text" name="offer_description" value="" class="form-control"></div>' .
	'<input value="edit" type="submit" name="edit" class="btn btn-warning"></form>';

}
?>
</div>
</body>
</html>