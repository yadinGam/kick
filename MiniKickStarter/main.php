<html>
<head>
<title>MyKick - Main</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

</head>

<body>

<?php
if (isset ($_COOKIE['username']) && isset ($_COOKIE['password'])) {
		echo
			'<nav class="navbar navbar-default">' .
			'<nav class="navbar navbar-inverse navbar-fixed-top">' .
			'<div class="col-md-5 col-md-offset-4">' .
			'<br><br>' .
			'<h1 class="registration_h2">Welcome ' . $_COOKIE['username'] . '!</h1>' .
			'<a role="button" class="btn btn-warning pull-right my_btn" href="logout.php">Log Out</a><br>' .
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
					'<li><a href="projectForm.php">Add a project</a></li>' .
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
}
else {

	echo
	'<nav class="navbar navbar-inverse navbar-fixed-top">' .
	'<div class="container fff">' .
	'<h2 class="main_h2" >Please enter username and password in order to login</h2>' .
	'	<div id="navbar" class="navbar-collapse collapse">' .
	'	<form action="login.php" method="POST" class="navbar-form navbar-left form-inline">' .
	'  	<div class="form-group">   ' .
	'  	<input type="text" name="username" placeholder="Username" class="form-control">' .
	'  	</div>	' .
	' 	<div class="form-group">' .
	' 	<input type="password" name="password" placeholder="Password" class="form-control">' .
	'   </div>	' 	.
	'	<button name="login" type="submit" class="btn btn-info">Log in</button>' .
	'   <br><br> ';
	if (isset ($_GET['notify'])) {
		echo
			'<div id="id" class = "alert_p">' .
			$_GET['notify'] .
			'</div>' .
			'<br> '  ;
	}

	echo
	'	<br> ' .
	' 	</div> ' .
    '   </form> ' .
    '   </div> ' .
    '	</div> ' .
	' 	</nav> ' ;
	if (isset ($_GET['notify'])) {
		echo
		'<br><br>';
	}
	echo
		' 	<br><br><br><br><br><br> ' .
		' 	<div class="jumbotron"> ' .
		' 	<div class="container"> ' .
		' 	    <h1>MyKick - <small>The new KickStarter platform!</small></h1> ' .
		' 	<p>If you ever wanted to create your own project but didn\'t have what it takes, or wanted to back a project that you know is great - THIS IS YOUR PLATFORM</p> ' .
		' 	<p><a class="btn btn-success btn-lg" href="registration.php" role="button">Sign up</a></p> ' .
		' 	</div> ' .
		' 	</div> ' ;

}
?>
<div class="container">
<?php
getproject();

function getprojects() {
	getproject();
}

function getproject() {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("select * from project");
	echo '<table class="table table-bordered">';
	$counter = 1;
	while ($row = mysqli_fetch_array($result)) {
		$project_name = $row['project_name'];
		$project_id = $row['project_id'];

		$start_date = $row['start_date'];
		$start_time = strtotime($start_date);

		$expiration_date = $row['expiration_date'];
		$expiration_time = strtotime($expiration_date);

		if(timePercentage($start_time, $expiration_time)<100)
		{
			echo '<td><h3 class="text-center"><b>' . $row['project_name'] . '</b></h3></br>' .
			'<div class="container-fluid">' .
			' Asked amount : ' . $row['wanted_amount'] . '<br/>' .
			' Minimum donation : ' . $row['one_bid'] . '<br/>' .
			' Donors : ' . calculate_num_of_donors($project_id) . '<br/>' .
			' Donation percentage : ' . calculate_donation_precentage($project_id, $row['wanted_amount']) . '%<br/>' .
			' Donation progress :' .
			' <div class="progress"> ' .
			' <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:'  . calculate_donation_precentage($project_name, $row['wanted_amount']) . '%">' .
			' </div> ' .
			' </div>' .
			' Project description : ' . $row['project_description'] . '<br/>' .
			' Offer description : ' . $row['offer_description'] . '<br/>' .
			' Image : </br><div><img height ="250" width = "250" src="data:image;base64,' . displayimage($project_id) . '"></div>' .
			' Video: ' . videoUrl($project_id) . '<br/>' .
			' </div> '.
			' Time left: '. timeDiff($expiration_time).'<br>' .
			' Time progress: <br>' . drawProgressForPercent(timePercentage($start_time,$expiration_time))	. '<br>' .
			' </td> ';
			if ($counter % 3 == 0) {
				echo '</tr>';
			}
			$counter++;
		}
	}
	if($counter % 3 == 0){
		echo ' <td></td>';
	}
	elseif($counter % 3 == 1){

	}
	else{
		echo ' <td></td><td></td>';
	}



	echo '</table>';
	mysqli_close($con);
}

function calculate_donation_precentage($project_id, $wanted_amount) {
	$donations = 0;
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("SELECT * FROM `doner`");
	while ($row = mysqli_fetch_array($result)) {
		if ($row['project_id'] == $project_id) {
			$donations = $donations + $row['amount'];
		}
	}

	$precentage = ($donations / $wanted_amount) * 100;
	$precentage = number_format($precentage, 2, '.', '');
	mysqli_close($con);
	return $precentage;

}

function displayimage($project_id) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("SELECT * FROM `images`");
	while ($row = mysqli_fetch_array($result)) {
		if ($row['project_id'] == $project_id) {
			return $row['image'];
		}
	}
	mysqli_close($con);
}

function calculate_num_of_donors($project_id) {
	$num_of_donors = 0;
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$result = $con->query("SELECT * FROM `doner`");
	while ($row = mysqli_fetch_array($result)) {
		if ($row['project_id'] == $project_id) {
			$num_of_donors += 1;
		}
	}
	return $num_of_donors;
	mysqli_close($con);

}

function videoUrl($project_id) {
	$con = new mysqli("localhost", "root", "", "final_project_db");
	$query = "SELECT * FROM `video` WHERE `project_id`='$project_id'";
	$result = mysqli_query($con, $query) or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$name = $row['name'];
			return '<a href = "watch.php?id=' . $id . '">' . $name . '</a>';
	}

}

function timeDiff($proj_exp_time)
{
	$remaining = $proj_exp_time - time();

	$days_remaining = floor($remaining / 86400);
	$hours_remaining = floor(($remaining % 86400) / 3600);
	return "$days_remaining Day(s) and $hours_remaining Hour(s)";
}

function timePercentage($proj_start_time, $proj_exp_time)
{
	if($proj_exp_time-$proj_start_time <= 0)
		return 100;
	$now = strtotime("now");

	$total_diff = $proj_exp_time - $proj_start_time;
	$today_diff = $proj_exp_time - $now;

	$percent = $today_diff / $total_diff;

	return $percent;
}

function drawProgressForPercent($percentage)
{
	$left_percentage = 100 - $percentage;
	if($left_percentage < 30)
	{
		return
			'<div class="progress">'.
			'<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.$left_percentage.'%">'.
			'</div>'.
			'</div>';
	}
	elseif($left_percentage < 60)
	{
		return
			'<div class="progress">'.
			'<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.$left_percentage.'%">'.
			'</div>'.
			'</div>';
	}
	else
	{
		return
			'<div class="progress">'.
			'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.$left_percentage.'%">'.
			'</div>'.
			'</div>';
	}
}
?>



    <footer>
        <p>Yadin Gamliel & Daniel Friedman 2015 - ALL RIGHTS RESERVED</p>
    </footer>
</div>
</body>                                                                                  
</html>

