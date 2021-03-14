<?php 
require_once 'functions.php';
if (!isLoggedIn()) {
	echo "<script>localStorage.clear(); window.parent.location.href = '/shree/login';</script>";
 	die();
}