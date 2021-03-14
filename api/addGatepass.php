<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die("Database Connection Failed");
	$cID = $_POST['id'];
	$gatepassNumber = $_POST['number'];
	$gatepassDate = $_POST['date'];
	$rollsInfo = $_POST['rollsInfo'];
	$status = 'Pending';

	$sql = "INSERT INTO `gatepasses`(`companyId`, `gatepassNumber`, `gatepassDate`, `rollsInfo`, `status`) VALUES ($cID, '$gatepassNumber','$gatepassDate', '$rollsInfo', '$status')";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}