<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<title>Monthly Sales Report | Shree Engineering Works</title>
 	<link rel="stylesheet" href="css/gstReport1.css" />
 	<link rel="stylesheet" href="css/snackbar.css" />
 </head>
 <body>
 	<img src="img/icon/back.png" alt="backBtn" id="backIcon" />
 	<h1>Monthly Sales Report</h1>
 	<select id="year">
 		<option value="">Loading...</option>
 	</select>
 	<select id="month" disabled="">
 		<option value="">Select Year First</option>
 	</select>
 	<br>
 	<br>
 	<button id="generate">View Report</button>
 	<br>
	<section class="recentReports">
		<span id="title">Recently Generated</span>
		<ul></ul>
	</section>
 	<span id="message"></span>
 	<footer>
 		<script src="js/salesReport.js"></script>
 	</footer>
 </body>
 </html>