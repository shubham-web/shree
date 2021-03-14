<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (!isset($_GET['tableName']) && !isset($_GET['columnName'])) {
		die("Invalid Request");
	}
	else{
		$tableName = $_GET['tableName'];
		$columnName = $_GET['columnName'];
	}
	$fetchYear = mysqli_query($con, "SELECT DISTINCT YEAR($columnName) as year FROM `$tableName`");
	$years = mysqli_num_rows($fetchYear);
	if ($years == 0) {
		echo "<option value=\"\">Nothing to show</option>";
	}
	else{
		for ($i=0; $i < $years; $i++) { 
			$year = mysqli_fetch_assoc($fetchYear)['year'];
			echo "<option value=\"$year\">".$year."</option>";
		}
	}