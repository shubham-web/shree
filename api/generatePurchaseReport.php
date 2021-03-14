<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (isset($_GET['year']) && isset($_GET['month'])) {
		$year = $_GET['year'];
		$month = $_GET['month'];
		if ($month > 12 || $year > 9999 || $year < 1111) die("Invalid Request");
	}
	else{
		die('Invalid Request');
	}
	$monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	$sqlQuery = "SELECT * FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year";
	$result = mysqli_query($con, $sqlQuery);
	$rows = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Monthly Purchase Report</title>
	<style>
		*{
			font-family: "Montserrat", sans-serif;
		}
		.center{
			text-align: center;
		}
		.right{
			text-align: right;
		}
		tr:nth-child(odd){
			background-color: #f1f1f1;
		}
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
	<h1 align="center">Purchase Report - <?php echo $monthArray[$month-1]; ?> <?php echo $year; ?></h1>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Vendor Name</th>
			<th>GSTIN</th>
			<th>Date</th>
			<th>Taxable Value</th>
			<th>CGST</th>
			<th>SGST</th>
			<th>IGST</th>
			<th>Total Value</th>
		</tr>
		<?php
			for ($i=0; $i < $rows; $i++) { 
				$data = mysqli_fetch_assoc($result);
				$vId = $data['vendorId'];
				$vendor = mysqli_fetch_assoc(mysqli_query($con, "SELECT name, gstin from `vendors` where id = $vId"));
				$vName = $vendor['name'];
				$gstin = $vendor['gstin'];
				$date = date("d-M-y", strtotime($data['date']));
				$taxable = $data['amount'];
		?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo $vName; ?></td>
			<td><?php echo $gstin; ?></td>
			<td><?php echo $date; ?></td>
			<td class="right"><?php echo $taxable; ?></td>
			<td class="right"><?php echo $data['cgst']; ?></td>
			<td class="right"><?php echo $data['sgst']; ?></td>
			<td class="right"><?php echo $data['igst']; ?></td>
			<td class="right"><?php echo $data['total']; ?></td>
		</tr>
		<?php } // For loop ?>
	</table>
<!-- ---------------------------------------------------------------- -->
<!-- ------------------------Report Summary-------------------------- -->
	<?php 
		$totalInvoiceValue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total) as totalInvoiceValue FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['totalInvoiceValue']; 
		$totalTaxableValue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount) as totalTaxableValue FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['totalTaxableValue']; 
		$totalCGST = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(cgst) as totalCGST FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['totalCGST'];
		$totalSGST = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(sgst) as totalSGST FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['totalSGST'];
		$totalIGST = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(igst) as totalIGST FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"))['totalIGST'];
		$totalTax = $totalInvoiceValue - $totalTaxableValue;
	?>
	<hr style="margin-top: 20px;">
	<table width="90%" align="center" cellspacing="0" cellpadding="5" style="font-size: 18px">
		<tr>
			<td>Total Invoice Value</td>
			<td>Rs. <?php echo ($totalInvoiceValue == '') ? '0':$totalInvoiceValue; ?></td>
		</tr>
		<tr>
			<td>Total Taxable Value</td>
			<td>Rs. <?php echo ($totalTaxableValue == '') ? '0':$totalTaxableValue; ?></td>
		</tr>
		<tr>
			<td>Total CGST</td>
			<td>Rs. <?php echo ($totalCGST == '') ? '0': $totalCGST; ?></td>
		</tr>
		<tr>
			<td>Total SGST</td>
			<td>Rs. <?php echo ($totalSGST == '')? '0':$totalSGST; ?></td>
		</tr>
		<tr>
			<td>Total IGST</td>
			<td>Rs. <?php echo ($totalIGST == '')? '0':$totalIGST; ?></td>
		</tr>
		<tr>
			<td>Total Tax</td>
			<td>Rs. <?php echo ($totalTax == '') ? '0':round($totalTax, 2); ?></td>
		</tr>
	</table>
	<hr>
	<button id="printBtn">Print</button>
	<footer>
		<script>
			printBtn = document.querySelector('#printBtn')
			printBtn.addEventListener('click', function () {
				printBtn.style.display = 'none'
				window.print()
			})
			window.addEventListener('afterprint', function () {
				printBtn.style.display = 'block'
			})
		</script>
	</footer>
</body>
</html>