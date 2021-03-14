<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die("Database Connection Failed");
	isset($_GET['id']) or die("Employee Id not Provided");
	$eId = $_GET['id'];
	!is_nan($eId) or die("invalid id");

	$sql = "SELECT totalDue FROM `advance` WHERE employeeId = $eId && id = (SELECT MAX(id) FROM advance WHERE employeeId = $eId)";
	$result = mysqli_query($con, $sql);
	$dueAmount = mysqli_fetch_assoc($result)['totalDue'];
	echo ($dueAmount == '') ? 0 : $dueAmount;