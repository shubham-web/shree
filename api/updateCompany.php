<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	function filtered($input)
	{	
		$input = trim($input);
		$input = str_replace("'", "\'", $input);
		$input = str_replace('"', '\"', $input);
		$input = htmlentities($input);
		return $input;
	}
	$cId = $_POST['id'];
	$name = filtered(ucwords($_POST['name']));
	$address = filtered($_POST['address']);
	$gstin = filtered(strtoupper($_POST['gstin']));
	$cp1 = filtered($_POST['cp1']);
	$cn1 = filtered($_POST['cn1']);
	$cp2 = filtered($_POST['cp2']);
	$cn2 = filtered($_POST['cn2']);
	$sql = "UPDATE `companies` SET `name`='$name',`address`='$address',`gstin`='$gstin',`contactPerson1`='$cp1',`contactNumber1`='$cn1',`contactPerson2`='$cp2',`contactNumber2`='$cn2' WHERE `id` = $cId";
	
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}