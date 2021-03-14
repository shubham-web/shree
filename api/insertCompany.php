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
	$name = filtered(ucwords($_POST['name']));
	$address = filtered($_POST['address']);
	$gstin = filtered(strtoupper($_POST['gstin']));
	$cp1 = filtered($_POST['cp1']);
	$cn1 = filtered($_POST['cn1']);
	$cp2 = filtered($_POST['cp2']);
	$cn2 = filtered($_POST['cn2']);
	$sql = "INSERT INTO companies(`name`, `address`, `gstin`, `contactPerson1`, `contactNumber1`, `contactPerson2`, `contactNumber2`) VALUES ('$name', '$address', '$gstin', '$cp1', '$cn1', '$cp2', '$cn2')";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}