<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (isset($_GET['month']) && isset($_GET['year'])) {
		$month = $_GET['month'];
		$year = $_GET['year'];
		$totalRows = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as rows FROM `salary` WHERE MONTH(date) = $month && YEAR(date) = $year"))['rows'];
		echo $totalRows;
	}
	else{
		echo "Invalid Request";
	}