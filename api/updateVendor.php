<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$id = $_POST['id'];
	$name = ucwords(htmlentities($_POST['name']));
	$address = $_POST['address'];
	$gstin = strtoupper($_POST['gstin']);
	$description = $_POST['description'];
	$sql = "UPDATE `vendors` SET `name`='$name',`address`='$address',`gstin`='$gstin', `description`= '$description' WHERE `id` = $id";
	
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}