<?php 
	include_once '../config.php';
	include_once 'functions.php';
	if (isset($_GET['DoxsG0tsqU']) && isset($_GET['smtWZ86pA2'])) {
		dbConnect();
		$email = $_GET['DoxsG0tsqU'];
		$pwd = $_GET['smtWZ86pA2'];
		$sql = "SELECT * FROM `login` WHERE md5(email) = '$email' AND password = '$pwd'";
		$result = mysqli_query($con, $sql);
		$rows = mysqli_num_rows($result);
		if ($rows === 0) {
			echo 'Session Expired';
		}
		else{
			echo '';
		}
	}