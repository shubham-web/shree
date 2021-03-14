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
	$date = $_POST['date'];
	$amount = filtered($_POST['amount']);
	$receiver = filtered($_POST['receiver']);
	$description = filtered($_POST['description']);
	if ($_POST['receiver'] == '') { $receiver = null; }
	if ($description == '') { $description = null; }
	$sql = "INSERT INTO `vouchers`(`date`, `amount`, `paidTo`, `description`) VALUES ('$date', $amount, '$receiver', '$description')";
	$result = mysqli_query($con, $sql);
	if ($result == 1) {
		echo "Success";
	}
	else{
		echo "Failure";
	}