<?php 
	require_once 'api/middleware.php';
	require_once 'config.php';
	
	dbConnect() or die("Database Connection Failed");
	
	$monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	// To get company's id whose bill is there
	$companyIdSql = "SELECT DISTINCT companyId from bills";
	$resultCompanyId = mysqli_query($con, $companyIdSql);
	$distinctCompanies = mysqli_num_rows($resultCompanyId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Pending Bills | Shree Engineering Works</title>
	<style>
		*{font-family: "Montserrat", sans-serif;}
		.center{text-align: center;}
		.right{text-align: right;}
		tr:nth-child(odd){background-color: #f1f1f1;}
		button{
			display: block;
			margin: 0 auto;
			cursor: pointer;
			font-size: 1em;font-weight: bold;
			padding: 10px;
			border-radius: 50px;
			outline: none;
		}
	</style>
</head>
<body>
	<h1 align="center">Unpaid Bills</h1>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Invoice Number</th>
			<th>Company Name</th>
			<th>Total Invoice(s)</th>
			<th>Total Invoice Value</th>
			<th>Total Taxable Value</th>
			<th>Total Payment Recieved</th>
			<th>Previous Balance</th>
			<th>Remaining Balance</th>
		</tr>
	</table>
	<hr>
	<button id="printBtn">Print</button>
	<footer>
		<script>
			printBtn.onclick = () => {
				printBtn.style.display = 'none'
				window.print()
			}
			window.onafterprint = () => { printBtn.style.display = 'block' }
		</script>
	</footer>
</body>
</html>