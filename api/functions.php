<?php 
	// Establish Connection with Database
	if ($_SERVER['REQUEST_URI'] == '/shree/api/functions.php') {
		die("Direct Access Not Allowed");
	}
	function dbError($errno, $errstr) {
		if (stripos($errstr,"mysqli_fetch_assoc()") === 0) {
			$readable = 'Unable To Fetch Data / The data is not available';
		}
		elseif (stripos($errstr,"mysqli_connect():") === 0) {			
			$readable = 'Error While Making Connection with Database / Wrong Credentials';
		}
		else{
			$readable = 'Uncaught Server Error : '.$errstr;
		}
		echo "<span style=\"background: red; color: #fff;\"><b>".$readable."</b></span>";
		die();
	}
	set_error_handler("dbError",E_ALL);
	function dbConnect()
	{
		global $con;
		// details are defined in Config.php File
		$con = mysqli_connect($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['serverPassword'], $GLOBALS['dbName']);
		return $con;
	}

	// Function to check Whether the user is logged in or not
	function isLoggedIn()
	{
		session_start();
		if (isset($_SESSION['email']) && isset($_SESSION['password']))  {
			return true;
		}
		else{
			session_destroy();
			return false;
		}
	}

	function logout()
	{
		session_start();
		return session_destroy();
	}

	if (isset($_POST['action'])) {
		if ($_POST['action'] == 'logout') {
			if (logout()) {
				echo "Success";
			}
			else{
				echo "Failure";
				die();
			}
		}
	}
 ?>