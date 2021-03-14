<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (!isset($_GET['companyId'])) die("Error : Company Id Not Provided");
	$companyId = $_GET['companyId'];
	$sql = "SELECT billNumber, paymentStts, billTotal, paymentRecieved FROM bills WHERE companyId = $companyId AND (paymentStts = 0 or paymentStts = 1)";
	$result = mysqli_query($con, $sql);
	$totalUnpaidBills = mysqli_num_rows($result);
	$output = [];
	for ($i=0; $i < $totalUnpaidBills; $i++) {
		$push = mysqli_fetch_assoc($result);
		array_push($output, $push);
	}
	echo json_encode($output);