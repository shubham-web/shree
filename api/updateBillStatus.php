<?php 
	require_once '../config.php';
	require_once 'middleware.php';	
	dbConnect();
	$billNumber = $_POST['billNumber'];
	$billStatus = ($_POST['billStatus'] === 'true')? 1 : 0;
	$remarks = $_POST['remarks'];
	$updateStatus = "UPDATE `bills` SET `billStatus`=$billStatus,`remarks`='$remarks' WHERE billNumber = '$billNumber'";
	$executeSQL = mysqli_query($con, $updateStatus);
	echo ($executeSQL) ? "DONE":"ERROR";