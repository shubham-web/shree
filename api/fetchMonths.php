<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (isset($_GET['year']) && isset($_GET['tableName']) && isset($_GET['columnName'])) {
		$year = $_GET['year'];
		$tableName = $_GET['tableName'];
		$columnName = $_GET['columnName'];
	}
	else{
		http_response_code(400);
		die('Invalid Request');
	}
	$fetchMonth = mysqli_query($con, "SELECT DISTINCT MONTH($columnName) as month FROM `$tableName` WHERE YEAR($columnName) = $year");
	$months = mysqli_num_rows($fetchMonth);
	$monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	for ($i=0; $i < $months; $i++) { 
		$month = mysqli_fetch_assoc($fetchMonth)['month'];
		$monthName = $monthArray[$month - 1];
		echo "<option value=\"$month\">".$monthName."</option>";
	}