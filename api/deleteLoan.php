<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect() or die("DB Connection Failure");
	isset($_GET['id']) or die("Transaction Id Not set");
	$id = $_GET['id'];

	$select = "SELECT * FROM `advance` where id = $id";
	$executeSelect = mysqli_query($con, $select);
	$data = mysqli_fetch_assoc($executeSelect);
	$jsonData = json_encode($data);

	// Insert Into Trash
	$insert = "INSERT INTO `trash`(`tableName`, `rowData`) VALUES ('advance', '$jsonData')";
	$executeInsert = mysqli_query($con, $insert);

	$delete = "DELETE FROM `advance` WHERE id = $id";
	echo ($result = mysqli_query($con, $delete)) ? "Deleted" : "Error";