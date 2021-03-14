<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$id = $_POST['purchaseId'];
	$invoiceNumber = $_POST['invoiceNumber'];
	$date = $_POST['date'];
	$vId = $_POST['id'];

	$amount = $_POST['amt'];
	$taxPercentage = $_POST['tax'];
	$gstin = mysqli_fetch_assoc(mysqli_query($con, "SELECT gstin FROM `vendors` WHERE id = $vId"))['gstin'];
	$taxAmt = intval(($amount * $taxPercentage) / 100);
	$tinNumber = substr($gstin, 0,2);
	if ($tinNumber == 23) {
		$cgst = $taxAmt / 2;
		$sgst = $taxAmt / 2;
		$igst = 0;
	}
	else{
		$cgst = 0;
		$sgst = 0;
		$igst = $taxAmt;
	}
	$total = $taxAmt + $amount;
	$description = $_POST['description'];

	$sql = "UPDATE `expenses` SET `invoiceNumber`='$invoiceNumber',`date`='$date',`amount`=$amount,`vendorId`=$vId,`taxPercentage`=$taxPercentage,`cgst`=$cgst,`sgst`=$sgst,`igst`=$igst,`total`=$total,`description`='$description' WHERE id=$id";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
		echo $sql;
	}