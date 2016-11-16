
<?php

if(isset($_GET['id'])){
	$id = $_GET['id'];
			$con = new mysqli("localhost", "root", "", "final_project_db");
		$query = "SELECT * FROM `video` WHERE `id`='$id'";
			$result = mysqli_query($con,$query)or die(mysqli_error($con));
				while( $row=mysqli_fetch_array($result) ){
					$name = $row['name'];
					$url = $row['url'];
					}	 
					echo $url;
	echo 'you are watching '.$name.'<br/>';
	echo '<embed src='.$url.' height="315" width = "560"> </embed>';
	echo '<p class="hhh"><a href ="main.php">Main page</a></p>';
}else{
	echo 'error!';
}


?>
