<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<title>GST Report 3B | Shree Engineering Works</title>
 	<link rel="stylesheet" href="css/gstReport1.css" />
 	<link rel="stylesheet" href="css/snackbar.css" />
 </head>
 <body>
 	<img src="img/icon/back.png" alt="backBtn" id="backIcon">
 	<h1>GST Report 3B</h1>
 	<select id="year">
 		<option value="">Loading...</option>
 	</select>
 	<select id="month" disabled="">
 		<option value="">Select Year First</option>
 	</select>
 	<br>
 	<br>
 	<button id="generate">View Report</button>
 	<div id="container">
 	</div>
 	<span id="message"></span>
 	<footer>
 		<script src="js/generategst2.js"></script>
 	</footer>
 </body>
 </html>