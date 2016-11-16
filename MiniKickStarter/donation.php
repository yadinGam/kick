<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
  <title>MyKick - Donate</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
if ($_COOKIE['usertype'] != 'doner') {
	echo
	'<nav class="navbar navbar-default">';
}
echo
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
	'<br><br><br><br><br><br><br>' ;
	if ($_COOKIE['usertype'] != 'doner') {
		echo

			'<div class="container-fluid">' .
			'<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">' .
			'<ul class="nav navbar-nav navbar-">';
		if ($_COOKIE['usertype'] == 'project_man') {
			echo
				'<li><a href="donerList.php">Watch donors</a></li>' .
				'<li><a href="projectMaintaince.php">Edit projects</a></li>' .
				'<li><a href="projectForm.php">Add a project</a></li>' .
				'<li><a href="deletion.php">Delete a project</a></li>';
		} else {
			echo
				'<li><a href="donerList.php">Watch donors</a></li>' .
				'<li><a href="projectMaintaince.php">Edit projects</a></li>' .
				'<li><a href="deletion.php">Delete a project</a></li>';
		}
		echo
			'</ul>' .
			'</div>' .
			'</div>' .
			'</nav>' .
			'<br>';
	}
?>

<div id="projectFormDiv" class="container col-md-6 col-md-offset-3">

<h1>Choose a project to donate to:</h1>


<?php
session_start();
$doner_name = $_SESSION['username'];
$doner_type = $_SESSION['usertype'];


if(check_if_donated_to_all($doner_name)!=1){pick_a_project($doner_name);}
else{echo '<div class="alert_p"><h3>You have donated to all the active projects!</h3></div>';}


function pick_a_project($doner_name) {
$selection = "Select";
echo '<form method ="post" class="form-group  col-md-3">
<select name = "mySelect" class="form-control">';
	echo '<option value=' . $selection . '>' . $selection . '</option>';
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("select * from project");
	while ($row = mysqli_fetch_array($result)) {
		if (!check_if_donated($row['project_name'], $doner_name)) {
			echo '<option value=' . $row['project_name'] . '>' . $row['project_name'] . '</option>';
		}

	}
	mysqli_close($con); 
	echo '</select>
<br>
<input value="Donate" type="submit" name="Donate" class="btn btn-success">
</form>';

if(isset($_POST['mySelect'])){if($_POST['mySelect']!="Select"){$project_name = $_POST['mySelect'];
get_onebidamount($project_name, $doner_name);
}
}

}

function check_if_donated($project_name, $doner_name){
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("SELECT * FROM doner WHERE doner_name = '$doner_name' and project_name = '$project_name'");
	$num_row = mysqli_num_rows($result);
	if ($num_row == 1) {
		return true;
	} else {
		return false;
	}
	mysqli_close($con);
}

function check_if_donated_to_all($doner_name) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("select * from project");
	$num_of_projects = mysqli_num_rows($result);
	$result = $con->query("SELECT * FROM doner WHERE doner_name = '$doner_name'");
	$counter = mysqli_num_rows($result);
	if ($num_of_projects == $counter) {
		return true;
	}
	return false;
}

function get_onebidamount($project_name, $doner_name) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("select * from project");
	$amount = "</br> select project to show amount ";
	echo '<br><br><br><br><div class="container"><br><h4>'.$project_name.'\'s minimum donation is: ';
	while ($row = mysqli_fetch_array($result)) {
		if ($project_name == $row['project_name']) {
			echo $row['one_bid'] . '$';
			$amount = $row['one_bid'];
			$_SESSION['projectid'] = $row['project_id'];
			mysqli_close($con);
		}
	}
	make_one_donation($doner_name, $project_name, $amount,$_SESSION['projectid'] );
}
function make_one_donation($doner_name, $project_name, $amount,$project_id) {
	echo  '<br>'. $doner_name . " has donated to " . $project_name . " " . $amount . "$<br></h3></div>";
	// insert bid into doner tabel
	if ($project_name) {
		$con = new mysqli("localhost", "root", "", "final_project_db");
		$result = $con->query("INSERT INTO `doner`(`doner_name`, `project_name`, `amount`, `project_id`) VALUES ('$doner_name','$project_name','$amount','$project_id')" );
	}
}
?>

</div>
</body>
</html>