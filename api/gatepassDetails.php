<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die('Database Connection Failed');
	isset($_GET['gatepassNumber']) or die("Gatepass Number Not Provided");
	$gatepassNumber = $_GET['gatepassNumber'];
	if (substr($gatepassNumber, 0,4) == 'byId') {
		$id = substr($gatepassNumber, 4);
		$sql = "SELECT rollsInfo from gatepasses WHERE id = '$id'";
	}
	else{
		$sql = "SELECT rollsInfo from gatepasses WHERE gatepassNumber = '$gatepassNumber'";
	}
	$result = mysqli_query($con, $sql);
	if ($result) {
		$rollsInfo = mysqli_fetch_assoc($result)['rollsInfo'];
		echo json_encode($rollsInfo);
	}
	else{
		echo "Error";
	}