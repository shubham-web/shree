<?php 
	include 'api/functions.php';
	if (isLoggedin()) { header('location:dashboard'); }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/snackbar.css" />
	<link rel="shortcut icon" href="favicon" />
	<title>Admin Login | Shree Engineering Works</title>
</head>
<body>
	<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>
	<form>
		<h1 id="heading">Admin Login</h1>
		<input type="email" placeholder="Email" name="email" required autocomplete="email" />
		<input type="password" name="password" required placeholder="Password" autocomplete="password" />
		<img src="icon/eye" id="show" title="Show Password" />
		<input type="checkbox" id="remember" checked />
		<label for="remember">Remember Me</label>
		<label for="frgtPWD"><a id="frgtPWD">Recover Password</a></label>
		<input type="submit" value="Login" id="proceed" />
	</form>
	<span id="message"></span>
	<script src="js/main.js"></script>
</body>
</html>