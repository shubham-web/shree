<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$gatepassId = $_POST['gatepassId'];
	$cID = $_POST['id'];
	$gatepassNumber = $_POST['number'];
	$gatepassDate = $_POST['date'];
	$rollsInfo = $_POST['rollsInfo'];
	$status = $_POST['status'];

	$sql = "UPDATE `gatepasses` SET `companyId`=$cID,`gatepassNumber`='$gatepassNumber',`gatepassDate`='$gatepassDate',`rollsInfo`='$rollsInfo',`status`='$status' WHERE id = $gatepassId";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}