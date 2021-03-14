<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die("Database Connection Failed");
	if (isset($_GET['month']) && isset($_GET['year'])) {
		$month = $_GET['month'];
		$year = $_GET['year'];
	}
	else{
		die("Invalid Request - Month / Year Not Provided");
	}
	// 1. number of Bills created in current month and sum of their totalAmount
	$bills = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as totalBills, SUM(billTotal) as worth FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year"));
	$totalBills = $bills['totalBills'];
	$billAmount = $bills['worth'];

	// 2. Total Spent Amount in current month from expenses table.	
	$spentAmount = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total) as spentAmount FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['spentAmount'];

	// 3. Number of chalans generated in this month
	$chalans = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as chalans FROM `chalans` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['chalans'];

	// 4. Number of gatepasses received in current month.
	$gatepasses = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as gatepasses FROM `gatepasses` WHERE MONTH(gatepassDate) = $month AND YEAR(gatepassDate) = $year"))['gatepasses'];
	// 5. Number of pending gatepasses of all time
	$pendingGatepasses = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as pending FROM `gatepasses` WHERE status = 'Pending'"))['pending'];
	$statistics = array('totalBills' => $totalBills,
						 'billAmount' => number_format($billAmount),
						 'spentAmount' => number_format($spentAmount),
						 'chalans' => $chalans,
						 'gatepasses' => $gatepasses,
						 'pendingGatepasses' => $pendingGatepasses
 						);
	echo json_encode($statistics);