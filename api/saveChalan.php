<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$date = $_POST['date'];
	$companyId = $_POST['companyId'];
	$gNumber = $_POST['gNumber'];
	$vehicleNumber = $_POST['vehicleNumber'];
	$rollsInfo = $_POST['rollsInfo'];
	$addChalan = "INSERT INTO `chalans` ( `date`, `companyId`, `gatepassNumber`, `vehicleNumber`, `rollsInfo`) VALUES ('$date', $companyId, '$gNumber', '$vehicleNumber', '$rollsInfo')";
	$add = mysqli_query($con, $addChalan);
	if ($add) {
		$sql = "SELECT MAX(number) as lastChalan FROM `chalans`";
		$execute = mysqli_query($con, $sql);
		$data = mysqli_fetch_assoc($execute);
		echo $data['lastChalan'];
	}
	else{
		echo "Error";
	}