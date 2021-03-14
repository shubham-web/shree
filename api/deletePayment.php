<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die('Database Connection Failed');
	if (!isset($_GET['id'])) die("Payment Id Not Provided");

	$paymentId = $_GET['id'];
	$sql = "SELECT * FROM `payments` WHERE id = $paymentId";
	$result = mysqli_query($con, $sql);

	$rows = mysqli_num_rows($result);
	if ($rows != '1') die("Payment Details Not Found");

	$paymentData = mysqli_fetch_assoc($result);
	$paidBills = json_decode($paymentData['paidBills'], true);
	for ($i=0; $i < count($paidBills); $i++) { 
		$invoiceNumber = $paidBills[$i]['invoice'];
		$amountPaid = $paidBills[$i]['amt'];
		$sql = "UPDATE `bills` SET `paymentStts`= 0,`paymentRecieved`= paymentRecieved - $amountPaid WHERE `billNumber`='$invoiceNumber'";
		$updateBill = mysqli_query($con, $sql);
		if (!$updateBill) die("Error While Updating Associated Bills");
	}

	$jsonData = json_encode($paymentData);
	$insert = "INSERT INTO `trash`(`tableName`, `rowData`) VALUES ('payments', '$jsonData')";
	$executeInsert = mysqli_query($con, $insert);

	$delete = "DELETE FROM `payments` WHERE `payments`.`id` = $paymentId";
	echo ($result = mysqli_query($con, $delete)) ? "Deleted" : "Error";