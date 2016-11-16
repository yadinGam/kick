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
	'</nav>' ;
?>
<div class="container">
<div id="projectFormDiv" class="container col-md-6 col-md-offset-3">
	<div class ="formAlert" >
		<?php
		if (isset ($_GET['notify'])) {
			echo $_GET['notify'];
		}
		?>
	</div>
	<h1>Step 1:</h1>
	<h2>Fill in the the details of the project</h2>
	<form action="projectConfirmation.php" method="POST" class="form-group">
	<label for="project_name">Project name :</label>
		<input type="text" maxlength="20" name="project_name" required class="form-control">
	<label for="one_bid">Minimum donation :</label>
		<input type="number" name="one_bid" required class="form-control">
	<label for="wanted_amount">Wanted amount :</label>
		<input type="number" name="wanted_amount" required class="form-control">
	<label for="project_description">Project description :</label>
		<textarea name="project_description" rows="3" cols="50" class="form-control"></textarea>
	<label for="offer_description">Offer description :</label>
		<textarea name="offer_description" rows="3" cols="50" class="form-control"></textarea>
	<label for="days">Days till expire :</label>
		<input type="number" name="days" required class="form-control">
	<label for="one_bid">Hours till expire :</label>
		<input type="number" name="hours" required class="form-control">
	<br>
	<br>
		<input type="submit" id="buttonSubmit" name="submit" value="Next" class="btn btn-success">
	</form>
</div>
</div>
</body>
<html>


