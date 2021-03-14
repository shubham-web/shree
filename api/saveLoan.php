<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die("Database Connection Failure");
	$eId = $_POST['eId'];
	$date = $_POST['date'];
	$taken = $_POST['taken'];
	$returned = $_POST['returned'];

	$sql = "SELECT totalDue FROM `advance` WHERE employeeId = $eId && id = (SELECT MAX(id) FROM advance WHERE employeeId = $eId)";
	$result = mysqli_query($con, $sql);
	$dueAmount = mysqli_fetch_assoc($result)['totalDue'];
	$dueAmount = ($dueAmount == '') ? 0 : $dueAmount;
	$totalDue = $dueAmount + $taken - $returned;

	$sql = "INSERT INTO `advance`(`employeeId`, `date`, `takenAmt`, `returnedAmt`, `totalDue`) VALUES ($eId, '$date', '$taken', '$returned', '$totalDue')";
	$result = mysqli_query($con, $sql);
	echo ($result) ? "Success": "Failure";