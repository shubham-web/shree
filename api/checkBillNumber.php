<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	if (dbConnect()) {
		$billNumber = $_POST['billNumber'];
		$sql = "SELECT id FROM `bills` WHERE billNumber = '$billNumber'";
		$result = mysqli_query($con, $sql);
		$num = mysqli_num_rows($result);
		if ($num == 1) {
			echo true;
		}
		else if($num == 0){
			echo false;
		}
	}
	else{
		echo "Database Connection Failed";
	}