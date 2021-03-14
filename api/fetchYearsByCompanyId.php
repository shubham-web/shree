<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (!isset($_GET['tableName']) && !isset($_GET['companyId'])) {
		die("Invalid Request");
	}
	else{
		$tableName = $_GET['tableName'];
		$companyId = $_GET['companyId'];
		$columnName = '';
		if ($tableName == 'gatepasses') {
			$columnName = 'gatepassDate';
		}
		elseif ($tableName == 'chalans') {
			$columnName = 'date';
		}
		elseif ($tableName == 'bills') {
			$columnName = 'billDate';
		}
		elseif ($tableName == 'payments') {
			$columnName = 'paymentDate';
		}
	}
	$fetchYear = mysqli_query($con, "SELECT DISTINCT YEAR($columnName) as year FROM `$tableName` where companyId = $companyId");
	$years = mysqli_num_rows($fetchYear);

	$outputArray = [];
	for ($i=0; $i < $years; $i++) { 
		$year = mysqli_fetch_assoc($fetchYear)['year'];
		array_push($outputArray, $year);
	}
	echo json_encode($outputArray);