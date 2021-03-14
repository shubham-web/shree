<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$date = $_POST['date'];
	$cId = $_POST['cId'];
	$mode = $_POST['mode'];
	$amount = $_POST['amount'];
	$paymentInfo = json_decode($_POST['paymentInfo']);
	$description = $_POST['description'];
	$paidBillsInfo = [];
	for ($i=0; $i < count($paymentInfo); $i++) {
		$push = array('invoice' => $paymentInfo[$i][0], 'amt' => $paymentInfo[$i][1]);
		array_push($paidBillsInfo, $push);
	}
	$paidBillsInfo = json_encode($paidBillsInfo);

	$sql = "INSERT INTO `payments`(`paymentDate`, `companyId`, `modeOfPayment`, `paymentAmount`,`paidBills`, `description`) VALUES ('$date', $cId, '$mode', $amount,'$paidBillsInfo', '$description')";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		$done = false;
		for ($j=0; $j < count($paymentInfo); $j++) { 
			$billNumber = $paymentInfo[$j][0];
			$paymentStts = $paymentInfo[$j][2];
			$amtRecieved = $paymentInfo[$j][1];
			$sql2 = "UPDATE `bills` SET `paymentStts`= $paymentStts,`paymentRecieved`= paymentRecieved + $amtRecieved WHERE `billNumber`='$billNumber'";
			$updateBill = mysqli_query($con, $sql2);
			if ($updateBill) {
				$done = true;
			}
			else{
				$done = false;
				break;
			}
		}
		if ($done) {
			echo "Success";
		}
		else{
			echo "Failure";
		}
	}
	else{
		echo "Failure";
	}