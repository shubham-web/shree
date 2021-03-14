<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<title>Company Wise Reports | Shree Engineering Works</title>
 	<link rel="stylesheet" href="css/companyWiseReports.css" />
 	<link rel="stylesheet" href="css/snackbar.css" />
 </head>
 <body>
 	<img src="img/icon/back.png" alt="backBtn" id="backIcon">
 	<h1>Company Wise Reports</h1>
 	<select id="company">
 		<option value="">---Select Comapany---</option>
 	</select>
	<br>

 	<select id="reportOf">
 		<option value="gatepasses">All Gatepasses</option>
 		<option value="chalans">All Chalans</option>
 		<option value="bills">All Bills</option>
 		<option value="payments">All Payments</option>
 	</select>
 	<br><br>
	
	<main id="criteria">
	 	<input type="radio" name="criteria" id="yearWise" />
	 	<label for="yearWise" title="Report from April To March of Selected Year">Year Wise</label>
	 	<input type="radio" name="criteria" id="monthWise" />
	 	<label for="monthWise" title="Report of Full Month">Month Wise</label>
	 	<input type="radio" name="criteria" id="dateWise" />
	 	<label for="dateWise" title="Report of Specific Date">Date Wise</label>
		<br><br>

		<section id="yearWiseInput" class="hide">
			<select id="yearOnly">
				<option value="">---Select Year---</option>
			</select>
		</section>
		
		<section id="monthWiseInput" class="hide">
			<select id="monthWiseYear">
				<option value="">---Select Year---</option>
			</select>
			<select id="monthWiseMonth" disabled>
				<option value="">---Select Year First---</option>
			</select>
		</section>

		<section id="dateWiseInput" class="hide">
			<table>
				<tr>
					<td>From</td>
					<td><input type="date" min="1900-01-01"  id="dateWiseFrom" /></td>
				</tr>
				<tr>
					<td>To</td>
					<td><input type="date" min="1900-01-01" id="dateWiseTo" /></td>
				</tr>
			</table>
		</section>
	</main>
	<br>
	<button id="submitBtn">View Report</button>
	<br>
	<section class="recentReports">
		<span id="title">Recently Generated</span>
		<ul></ul>
	</section>
 	<span id="message"></span>
 	<footer>
 		<script src="js/comapanyWiseReports.js"></script>
 	</footer>
 </body>
 </html>