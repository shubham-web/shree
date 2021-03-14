<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	
	dbConnect() or die("Database Connection Failed");
	if (isset($_GET['year']) && isset($_GET['month'])) {
		$year = $_GET['year'];
		$month = $_GET['month'];
		if ($year > 9999 || $year < 1800 || $month > 12 || $month < 1) {
			echo "<h1>Invalid Month / Year Provided</h1>";
			die();
		}
	}
	else{
		die('Invalid Request');
	}
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
	<title>Monthly Sales Report</title>
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
	<h1 align="center">Sales Report - <?php echo $monthArray[$month-1]." ".$year; ?></h1>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Company Name</th>
			<th>Invoice Number(s)</th>
			<th>Total Invoice(s)</th>
			<th>Total Invoice Value</th>
			<th>Total Taxable Value</th>
			<th>Total Payment Recieved</th>
			<th>Previous Balance</th>
			<th>Remaining Balance</th>
		</tr>
<?php 
	$serial = 1;
	for ($i=0; $i < $distinctCompanies; $i++) {
		$companyId = mysqli_fetch_assoc($resultCompanyId)['companyId'];
		# To get Company Name Based on ID
		$companyName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `companies` WHERE id = $companyId"))['name'];

		# To get bill numbers based on comapany id
		$invoicesSql = "SELECT billNumber from bills WHERE companyId = $companyId AND MONTH(billDate) = $month AND YEAR(billDate) = $year";
		$resultInvoices = mysqli_query($con, $invoicesSql);
		$totalInvoices = mysqli_num_rows($resultInvoices);

		# To get total invoice value 
		$invoiceValueSQL = "SELECT SUM(`billTotal`) as totalInvoiceValue FROM `bills` WHERE companyId = $companyId AND MONTH(billDate) = $month AND YEAR(billDate) = $year";
		$resultInvoiceValue = mysqli_query($con, $invoiceValueSQL);
		$totalInvoiceValue = mysqli_fetch_assoc($resultInvoiceValue)['totalInvoiceValue'];

		# To get total taxable value 
		$taxableValueSQL = "SELECT SUM(`billAmount`) as totalTaxableValue FROM `bills` WHERE companyId = $companyId AND MONTH(billDate) = $month AND YEAR(billDate) = $year";
		$resultTaxableValue = mysqli_query($con, $taxableValueSQL);
		$totalTaxableValue = mysqli_fetch_assoc($resultTaxableValue)['totalTaxableValue'];

		# To get total payment recieved from company in selected month
		$totalPaymentSQL = "SELECT SUM(`paymentAmount`) paymentRecieved FROM `payments` WHERE companyId = $companyId AND MONTH(paymentDate) = $month AND YEAR(paymentDate) = $year";
		$resultTotalPayment = mysqli_query($con, $totalPaymentSQL);
		$totalPayment = mysqli_fetch_assoc($resultTotalPayment)['paymentRecieved'];

		# To get total invoice value before this month 
		$totalInvoiceValueBeforeMonthSQL = "SELECT sum(billTotal) as invoiceValueBeforeThisMonth FROM `bills` WHERE companyId = $companyId AND ((MONTH(billDate) < $month AND YEAR(billDate) = $year) OR (YEAR(billDate) < $year))";
		$resultInvoiceValBeforeMonth = mysqli_query($con, $totalInvoiceValueBeforeMonthSQL);
		$totalInvoiceValueBeforeMonth = mysqli_fetch_assoc($resultInvoiceValBeforeMonth)['invoiceValueBeforeThisMonth'];
		if ($totalInvoiceValueBeforeMonth == null) {
			$totalInvoiceValueBeforeMonth = 0;
		}

		# To get total payment Recieved before this month
		$totalPaymentBeforeThisMonth = "SELECT sum(paymentAmount) as totalPaymentRecievedBeforeThisMonth FROM `payments` WHERE companyId = $companyId AND ((MONTH(paymentDate) < $month AND YEAR(paymentDate) = $year) OR (YEAR(paymentDate) < $year))";
		$resultPaymentBeforeMonth = mysqli_query($con, $totalPaymentBeforeThisMonth);
		$totalPaymentRecievedBeforeThisMonth = mysqli_fetch_assoc($resultPaymentBeforeMonth)['totalPaymentRecievedBeforeThisMonth'];
		if ($totalPaymentRecievedBeforeThisMonth == null) {
			$totalPaymentRecievedBeforeThisMonth = 0;
		}

		$previousBalance = $totalInvoiceValueBeforeMonth - $totalPaymentRecievedBeforeThisMonth;
		if ($totalInvoices == '' && $previousBalance == 0) {
			continue;
		}
?>
		<tr>
			<td>
				<?php echo $serial++; // Serial number ?>
			</td>

			<td>
				<?php echo $companyName; ?>	
			</td>

			<td>
				<?php 
					if ($totalInvoices == '') {
						echo "-";
					}
					else{
						for ($j=0; $j < $totalInvoices; $j++) { 
							$billNumber = mysqli_fetch_assoc($resultInvoices)['billNumber'];
							echo $billNumber;
							echo ($j != $totalInvoices - 1) ? ",":"";
						}
					}
				?>
			</td>

			<td class="center"><?php echo $totalInvoices; ?></td>

			<td class="right">
				<?php echo ($totalInvoiceValue == '' ) ? "0": $totalInvoiceValue; ?>
			</td>

			<td class="right">
				<?php echo ($totalTaxableValue == '' ) ? "0": $totalTaxableValue; ?>	
			</td>

			<td class="right">
				<?php echo ($totalPayment == '')? "0": $totalPayment; ?>
			</td>

			<td class="right"><?php echo $previousBalance; ?></td>

			<td class="right"><?php echo ($totalInvoiceValue - $totalPayment) + $previousBalance; ?></td>
		</tr>
<?php } // For loop ?>
	</table>
<!-- ---------------------------------------------------------------- -->
<!-- ------------------------Report Summary-------------------------- -->
	<?php 
		$totalAmountReceived = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(paymentAmount) as totalPayment FROM `payments` WHERE MONTH(paymentDate) = $month and YEAR(paymentDate) = $year"))['totalPayment']; 
		$totalBills = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(billNumber) totalBills FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year"))['totalBills'];
		$totalTaxableAmount = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(billAmount) totalTaxableAmount FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year"))['totalTaxableAmount'];
		$totalInvoiceAmount = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(billTotal) totalInvoiceAmount FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year"))['totalInvoiceAmount'];
		

		$totalTax = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(sgst + cgst + igst) as totalTax FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year"))['totalTax'];


	?>
	<hr style="margin-top: 20px;">
	<table width="90%" align="center" cellspacing="0" cellpadding="5" style="font-size: 18px">
		<tr>
			<td>Total Number of Bills Generated</td>
			<td><?php echo ($totalBills == '') ? '0':$totalBills; ?></td>
		</tr>
		<tr>
			<td>Total Amount Received</td>
			<td>Rs. <?php echo ($totalAmountReceived == '') ? '0':$totalAmountReceived; ?></td>
		</tr>
		<tr>
			<td>Total Taxable Value</td>
			<td>Rs. <?php echo ($totalTaxableAmount == '') ? '0': $totalTaxableAmount; ?></td>
		</tr>
		<tr>
			<td>Total Invoice Value</td>
			<td>Rs. <?php echo ($totalInvoiceAmount == '')? '0':$totalInvoiceAmount; ?></td>
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
			printBtn.onclick = () => {
				printBtn.style.display = 'none'
				window.print()
			}
			window.onafterprint = () => { printBtn.style.display = 'block' }
		</script>
	</footer>
</body>
</html>