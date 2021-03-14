<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	function filtered($input)
	{	
		$input = trim($input);
		$input = str_replace("'", "\'", $input);
		$input = str_replace('"', '\"', $input);
		$input = str_replace('&', ' and ', $input);
		$input = htmlentities($input);
		return $input;
	}
	$name = ucwords(filtered($_POST['name']));
	$address = filtered($_POST['address']);
	if ($_POST['description'] == '') {
		$description = null;
	}
	else{
		$description = filtered($_POST['description']);
	}
	$gstin = strtoupper(filtered($_POST['gstin']));
	$sql = "INSERT INTO `vendors`( `name`, `address`, `description`, `gstin`) VALUES ('$name', '$address', '$description', '$gstin')";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}