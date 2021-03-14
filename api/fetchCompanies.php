<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$sql = "SELECT id,name FROM `companies` ORDER BY name asc";
	$result = mysqli_query($con, $sql);
	$totalComapanies = mysqli_num_rows($result);
	$companies = array();
	for ($i=0; $i < $totalComapanies; $i++) { 
		$companyData = mysqli_fetch_assoc($result);
		$id = $companyData['id'];
		$name = $companyData['name'];
		array_push($companies, [$id, $name]);
	}
	echo json_encode($companies);