
<?php
session_start();

$con = mysqli_connect("127.0.0.1", "root", "", "final_project_db") or die(mysqli_errno());
//project id
$project_name = $_POST['project_name'];
$wanted_amount = $_POST['wanted_amount'];
$one_bid = $_POST['one_bid'];
$project_description = $_POST['project_description'];
$user_id = $_SESSION['userid'];
$offer_description = $_POST['offer_description'];
$days = $_POST['days'];
$hours = $_POST['hours'];
//$start_date = $_POST['start_date'];
//$start_date = $_POST['start_date'];
//$expiration_date = $_POST['expiration_date'];
//$start_time = $_POST['start_time'];
//$expiration_time = $_POST['expiration_time'];

$start_time = strtotime("+1 hour");
$start_date = date("Y-m-d H:i:s", $start_time);

if($days < 0  || $hours < 0 || ($days == 0 && $hours == 0 ))
{
	$expiration_time = strtotime("+1 month +1 hour");
	$expiration_date = date("Y-m-d H:i:s", $expiration_time);
}
else
{
	$expiration_time = $start_time;
	$expiration_date = date("Y-m-d H:i:s", $expiration_time);
	$expiration_date = addDate($expiration_date, $days, $hours);
}





$_SESSION['project_name'] = $project_name;

//if project name doesn't exists insert into table
if (check_if_project_name_taken($project_name) == true)
{
	header("location:projectForm.php?notify=project already exists ");
}
else
{
	$query = "INSERT INTO project" .
	" (project_name, wanted_amount,one_bid ,project_description,user_id,offer_description,start_date,expiration_date)" .
	" VALUES ( '$project_name', '$wanted_amount','$one_bid','$project_description','$user_id','$offer_description','$start_date','$expiration_date')";
	$con->query($query);
	$con->close();
	header("Location:insertPic.php?notify= Congrats you have registered a new project");

}

function check_if_project_name_taken($project_name) {
	$mysqli = new mysqli('localhost', 'root', '', 'final_project_db');
	$result = $mysqli->query("SELECT * FROM final_project_db.project WHERE project_name='$project_name'");
	if ($result->num_rows >= 1) {
		return true;
	}
	return false;
}

function addDate($date,$days,$hours)
{
	$sum = strtotime(date("Y-m-d H:i:s", strtotime("$date")) . " +$days days +$hours hours");
	$newDate = date('Y-m-d H:i:s', $sum);
	return $newDate;
}
?>

