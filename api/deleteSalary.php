<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	$date = $_GET['date'];
	$delete = "DELETE FROM salary WHERE date = '$date'";
	if ($result = mysqli_query($con, $delete)) {
		echo "Deleted";
	}
	else{
		echo "Error";
	}