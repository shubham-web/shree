<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	if (dbConnect()) {
		$gatepassNumber = $_POST['gatepassNumber'];
		$companyId = $_POST['companyId'];
		$sql = "SELECT id FROM `gatepasses` WHERE gatepassNumber = '$gatepassNumber' AND companyId = $companyId";
		$result = mysqli_query($con, $sql);
		$num = mysqli_num_rows($result);
		if ($num >= 1) {
			echo 'exists';
		}
		else if($num == 0){
			echo 'continue';
		}
	}
	else{
		echo "Database Connection Failed";
	}