<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (!isset($_GET['tableName']) || !isset($_GET['companyId']) || !isset($_GET['year'])) {
		die("Invalid Request");
	}
	else{
		$tableName = $_GET['tableName'];
		$companyId = $_GET['companyId'];
		$year = $_GET['year'];
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
	$fetchMonths = mysqli_query($con, "SELECT DISTINCT MONTH($columnName) as month FROM `$tableName` WHERE companyId = $companyId AND YEAR($columnName) = $year");
	$months = mysqli_num_rows($fetchMonths);

	$outputArray = [];
	for ($i=0; $i < $months; $i++) { 
		$push = mysqli_fetch_assoc($fetchMonths)['month'];
		array_push($outputArray, $push);
	}
	echo json_encode($outputArray);