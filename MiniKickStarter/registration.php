<html>
<head>
	<title>MyKick - Registration</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="col-md-4 col-md-offset-5">
		<br>
		<br>
		<h1 class="registration_h2">Registration</h1>
		<a role="button" class="btn btn-info pull-right" href="main.php">Back</a>
		<br><br><br>
	</div>
</nav>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
<form name="register" action="register.php" method="POST" class="form-horizontal">
		<div class="form-group">
			<label for="username" required class="col-sm-2 control-label">User name:</label>
			<div class="col-sm-10">
				<input type="text" required name="username" id="username" maxlength="40" class="form-control"  />
			</div>
		</div>
		<div class="form-group">
			<label for="password1" class="col-sm-2 control-label">Password:</label>
			<div class="col-sm-10">
				<input type="password" required name="password1" id="password1" class="form-control"  />
			</div>
		</div>
		<div class="form-group">
			<label for="password2" class="col-sm-2 control-label">Confirmation:</label>
			<div class="col-sm-10">
				<input type="password" required name="password2" id="password2" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email:</label>
			<div class="col-sm-10">
				<input type="email" required name="email" id="email" class="form-control" />
			</div>
		</div>
		<div class="form-group">

			<label for="admin" class="col-sm-2 control-label">User Type:</label>
			<br>
			<label class="radio-inline">
				<input type="radio" name="usertype" id = "doner" value = "doner"  >Contributor
			</label>
			<label class="radio-inline">
				<input type="radio" name="usertype" id = "project_man" value = "project_man"  >Project manager
			</label>
			</br>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-success">Register</button>
			</div>
		</div>
</form>
</div>
</body>
</html>
	<?php
if (isset ($_GET['notify'])) {
	echo $_GET['notify'];
}
?>
