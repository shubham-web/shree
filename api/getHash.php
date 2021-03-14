<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	if (isset($_POST['string'])) {
		$string = $_POST['string'];
		echo md5($string);
	}