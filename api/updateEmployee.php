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
	$id = $_POST['id'];
	$name = filtered(ucwords($_POST['name']));
	$qualification = filtered($_POST['edu']);
	$mobile = filtered($_POST['mobile']);
	$aadhar = filtered($_POST['aadhar']);
	$date = filtered($_POST['date']);
	if ($date == '') {
		$date = null;
	}
	$salary = filtered($_POST['salary']);
	$sql = "UPDATE `employees` SET `name`='$name',`qualification`='$qualification',`mobileNumber`='$mobile',`aadhar`='$aadhar',`joiningDate`='$date',`salary`=$salary WHERE id = $id";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}