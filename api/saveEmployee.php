<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	function filtered($input)
	{	
		if ($input == '') {
			return null;
		}
		else{
			$input = trim($input);
			$input = str_replace("'", "\'", $input);
			$input = str_replace('"', '\"', $input);
			$input = htmlentities($input);
			return $input;
		}
	}
	$name = filtered(ucwords($_POST['name']));
	$qualification = filtered($_POST['edu']);
	$mobile = filtered($_POST['mobile']);
	$aadhar = filtered($_POST['aadhar']);
	$date = filtered($_POST['date']);
	if ($_POST['date'] == '') { $date = null; }
	$salary = filtered($_POST['salary']);
	$sql = "INSERT INTO `employees`(`name`, `qualification`, `mobileNumber`, `aadhar`, `joiningDate`, `salary`) VALUES ('$name', '$qualification', '$mobile', '$aadhar', '$date', $salary)";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
		echo $sql;
	}