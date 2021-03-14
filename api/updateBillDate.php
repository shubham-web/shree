<?php 
	require_once '../config.php';
	require_once 'middleware.php';	
	dbConnect();
	$billNumber = $_POST['billNumber'];
	$newDate = $_POST['newDate'];

	$updateDate = "UPDATE `bills` SET `billDate`= '$newDate' WHERE billNumber = '$billNumber'";
	$executeUpdate = mysqli_query($con, $updateDate);
	echo ($executeUpdate) ? "DONE":"ERROR";