<?php 
	include_once '../config.php';
	include_once 'functions.php';
	if (isset($_POST['email']) && $_POST['password']) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		if (!dbConnect()) {
			die("Database Connection Failed");
		}
		else{
			$query = "SELECT * FROM login WHERE md5(email)='$email' and password='$password'";
			$result = mysqli_query($con, $query);
			$num_rows = mysqli_num_rows($result);
			if ($num_rows == 1) {
				session_start();
				$_SESSION['email'] = mysqli_fetch_assoc($result)['email'];
				$_SESSION['password'] = $password;
				echo "Success";
			}
			else{
				echo "Failure";
			}
		}
	}
	else{
		header('location:login');
	}