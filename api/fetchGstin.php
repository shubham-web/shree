<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	$companyId = $_GET['companyId'];
	$sql = "SELECT gstin FROM `companies` WHERE id = $companyId";
	$result = mysqli_query($con, $sql);
	$data = mysqli_fetch_assoc($result);
	$gstin = $data['gstin'];
	$pos = strpos($gstin, '23');
	if ($pos === 0) {
		echo true; // From MP
	}
	else{
		echo false; 
	}