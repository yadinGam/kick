<?php

session_start();



if(isset($_POST['login']))
{
	$con=mysqli_connect("127.0.0.1","root","", "final_project_db") or die(mysqli_errno());

	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$rrr = $_POST['password'];
		$password = md5($_POST['password']);
		
		if($username && $password) {
			$query = "SELECT * FROM final_project_db.users WHERE username='$username' AND password='$password'";
			$result = mysqli_query($con,$query)or die(mysqli_error($con));
			
			$num_row = mysqli_num_rows($result);
			if( $num_row == 1 )
			{
				while( $row=mysqli_fetch_array($result) ){
					$_SESSION['username'] = $row['username'];
					$_SESSION['userid'] = $row['id'];
					$_SESSION['usertype'] = $row['usertype'];
					setcookie('usertype', $_SESSION['usertype'], time()+60*60*24*365,false);
					header("location:main.php?notify= Logged in");
				}
				  
			      setcookie('username', $_POST['username'], time()+60*60*24*365,false);
   				  setcookie('password', md5($_POST['password']), time()+60*60*24*365,false);
   				  setcookie('userid', md5($_POST['userid']), time()+60*60*24*365,false);  
			} else {
				header("location:main.php?notify= Invalid Username or Password.");
			}
			
		}else{
			header("location:main.php?notify= No Username or Password. ");
		}
	}
}




?>

