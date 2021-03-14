<?php 
	require_once '../config.php';
	require_once 'middleware.php';	
	dbConnect();
	$id = $_POST['id'];
	$tableName = $_POST['tableName'];
	$select = "SELECT * FROM $tableName where id = $id";
	$executeSelect = mysqli_query($con, $select);
	$cData = mysqli_fetch_assoc($executeSelect);
	$jsonData = json_encode($cData);

	// Insert Into Trash
	$insert = "INSERT INTO `trash`(`tableName`, `rowData`) VALUES ('$tableName', '$jsonData')";
	$executeInsert = mysqli_query($con, $insert);

	$delete = "DELETE FROM `$tableName` WHERE id=$id";
	$executeDelete = mysqli_query($con, $delete);
	if ($executeDelete) {
		echo "Deleted";
	}
	else{
		echo "Error";
	}