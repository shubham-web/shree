<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<title>GST Report Bussiness to Bussines | Shree Engineering Works</title>
 	<link rel="stylesheet" href="css/gstReport1.css" />
 	<link rel="stylesheet" href="css/snackbar.css" />
 </head>
 <body>
 	<img src="img/icon/back.png" alt="backBtn" id="backIcon">
 	<h1>GST Report B2B</h1>
 	<select id="year">
 		<option value="">Loading...</option>
 	</select>
 	<select id="month" disabled="">
 		<option value="">Select Year First</option>
 	</select>
 	<br>
 	<br>
 	<button id="generate">View Report</button>
 	<button id="download" disabled>
 	<img src="icon/download" width="15" /> Download</button>
 	<div id="container">
 	</div>
 	<span id="message"></span>
 	<footer>
 		<script src="js/generategstr1.js"></script>
 	</footer>
 </body>
 </html>