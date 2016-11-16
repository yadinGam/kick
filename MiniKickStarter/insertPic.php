<html lang=''>
<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>MyKick - New Project - Step 1</title>
</head>
<body>


<?php
session_start();
$con = mysqli_connect("127.0.0.1", "root", "", "final_project_db") or die(mysqli_errno());
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
		<h1>Step 2:</h1>
		<h2>Choose a picture</h2>
		<form enctype="multipart/form-data" method="post" class="form-group">
			<input name="MAX_FILE_SIZE" value="102400" type="hidden">
			<span class="btn btn-info btn-file">
				Browse <input name="image" accept="image/jpeg" type="file">
			</span>
			<input value="Upload" type="submit" name="sumit" class="btn btn-success">
		</form>

<?php
	if (isset ($_POST['sumit'])) {
		if (getimagesize($_FILES['image']['tmp_name']) == false) {
			echo "please select an image";
		} else {
			$image = addslashes($_FILES['image']['tmp_name']);
			$name = addslashes($_FILES['image']['name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			
			//get the id 
			$project_name = $_SESSION['project_name'];
						$result = $con->query("SELECT `project_id` FROM `project` WHERE `project_name`= '$project_name'");
					 $row = mysqli_fetch_array($result);
				$project_id =  $row['project_id'];
			$_SESSION['project_id'] =$project_id; 
			
			saveimage($name,$project_name,$project_id,$image);
			header("location:insertVid.php");
		}
	}
	
	function saveimage($name,$project_name,$project_id,$image) {

		$con = new mysqli("localhost", "root", "", "final_project_db");
		$result = $con->query("insert into images (name,project_name,project_id,image)values ('$name','$project_name','$project_id','$image')");

		if ($result) {
			echo "<div> image uploaded.</div>";
		} else {
			echo "<div> image not uploaded.</div>";
		}

	}



	function displayimage() {
		$con = new mysqli("localhost", "root", "", "final_project_db");
		$result = $con->query("select * from images");
		while($row = mysqli_fetch_array($result)){
			echo '<img height="300" width="300" src="data:image;base64,'.$row[3].'" >';
		}
	mysqli_close($con);
	}
?>

</div>
</div>
</body>
</html>