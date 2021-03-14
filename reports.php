<?php require_once 'api/middleware.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageReports" />
	<link rel="stylesheet" href="css/graph" />
	<title>Manage Bills</title>
</head>
<body>
	<span class="heading">Generate Reports</span>
	<section id="reports">
		<div class="reportBox" id="gstr1">
			<span class="reportHead">B2B Report</span>
			<span class="reportSubHead">GSTR1</span>

			<span class="reportStatistics">Click To Generate Report</span>
		</div>

		<div class="reportBox" id="salesReport">
			<span class="reportHead">Sales Report</span>
			<span class="reportSubHead" id="totalBills">0 Bills This Month</span>

			<span class="reportStatistics" id="billAmt">Worth Rs. 0</span>
		</div>
		
		<div class="reportBox"  id="rollsDelivered">
			<span class="reportHead">Delivered Rolls</span>
			<span class="reportSubHead" id="chalans">0 Chalans Generated</span>

			<span class="reportStatistics">Get Report</span>
		</div>
		<div class="reportBox" id="pendingGatepasses">
			<span class="reportHead">Pending GatePasses</span>
			<span class="reportSubHead" id="pendingGp">0 Gatepasses are pending</span>

			<span class="reportStatistics">Click To View</span>
		</div>
		<div class="reportBox" id="gstr2">
			<span class="reportHead">3B Report</span>
			<span class="reportSubHead">GSTR2</span>

			<span class="reportStatistics">Click To Generate Report</span>
		</div>
		<div class="reportBox" id="purchaseReport">
			<span class="reportHead">Purchase Report</span>
			<span class="reportSubHead" id="spentAmt">Spent Rs. 0 This Month</span>

			<span class="reportStatistics">Get Report</span>
		</div>
		<div class="reportBox" id="rollsReceived">
			<span class="reportHead">Received Rolls</span>
			<span class="reportSubHead" id="totalGatepasses">0 Gatepasses Received</span>

			<span class="reportStatistics">Get Report</span>
		</div>
		<div class="reportBox" id="companyWiseReports">
			<span class="reportHead">Company Wise</span>
			<span class="reportSubHead">Bills, Gatepasses</span>

			<span class="reportStatistics">Chalans, Payments</span>
		</div>
	</section>
	<span class="heading">Cash Flow Graph</span>
	<aside id="pillerInfo">
		<h1 id="pillerType">Expenses</h1>
		<p id="pillerAmt">Rs. 20,1052</p>
	</aside>
	<section id="graph">
		<main>
			<?php
				for ($i=0; $i < 5; $i++) {
					echo "<div><div class=\"bar\"></div><div class=\"bar\"></div></div>";
				}
			?>
		</main>
		<footer><span></span><span></span><span></span><span></span><span></span></footer>
	</section>
	<footer>
		<script src="js/frameContext.js"></script>
		<script src="js/manageReports.js"></script>
	</footer>
</body>
</html>