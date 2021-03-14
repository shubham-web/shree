<?php 
	include_once '../config.php';
	include_once 'functions.php';
	if (isset($_POST['email']) && $_POST['password']) {
		$email = $_POST['email'];
		$password = md5($_POST['password']);

		if ($email == '') {
			echo "Enter Email";
		}
		elseif ($password == '') {
			echo "Enter Password";
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "Invalid Email";
		}
		else{
			if (dbConnect()){
				$query = "SELECT id FROM login WHERE email='$email' and password='$password'";
				$result = mysqli_query($con, $query);
				$num_rows = mysqli_num_rows($result);
				if ($num_rows == 1) {
					session_start();
					$_SESSION['email'] = $email;
					$_SESSION['password'] = $password;
					echo "Success";
				}
				else{
					echo "Login Failed";
				}
			}
		} // else (When Validations Are done)

	}
	else{
		header('location:login');
	}