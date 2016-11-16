<?php

session_start();
if(isset($_SESSION['username']) || isset($_SESSION['password']))
{
	session_destroy();
	header("location:main.php?notify=You have been Logged out.");
	setcookie('username',null, time()-1);
	setcookie('password',null, time()-1);
	setcookie('usertype',null, time()-1);
	setcookie('userid',null, time()-1);
	
}else{header("location:main.php?notify=You have been Logged out.");
	setcookie('username',null, time()-1);
	setcookie('password',null, time()-1);
	setcookie('usertype',null, time()-1);
		setcookie('userid',null, time()-1);
}

?>