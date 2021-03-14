<?php 
	if (isset($_GET['errorCode'])) {
		$errorCode = $_GET['errorCode'];
	}
	else{
		$errorCode = '';
	}
	switch ($errorCode) {
		case 400:
			$msg = 'Bad Request';
			break;
		case 401:
			$msg = 'Authentication Required';
			break;
		case 403:
			$msg = 'You don\'t have permission to access this page! ';
			break;
		case 404:
			$msg = 'This page doesn\'t Exist!' ;
			break;
		case 500:
			$msg = 'Looks like we\'re having some Server issue!';
			break;
		default:
			$msg = 'Unknown Error! ';
			break;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<style>
		*{
			font-family: "Montserrat", sans-serif;
		}
		*::selection{
			color: #4448e2;
			background-color: yellow;
		}
		body{
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			text-align: center;
			background-color: dodgerblue;
		}
		h1{
			color: #ffd;
		}
		#logo{
			width: 150px;
			height: 150px;
			background-color: #fff;
			border-radius: 50%;
		}
	</style>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="/shree/favicon" />
	<title>Error <?php echo $msg; ?> | Shree Engineering Works</title>
</head>
<body>
	<img src="/shree/logo" alt="Shree Engineering Works" id="logo" />
	<h1><?php echo $msg; ?></h1>
</body>
</html>