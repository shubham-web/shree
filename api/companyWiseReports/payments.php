<?php 
	require_once '../middleware.php';
	require_once '../../config.php';
	dbConnect() or die("Database Connection Failed");
	$monthArray = ['','January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	if (isset($_GET['criteria']) && isset($_GET['companyId'])) {
		$criteria = $_GET['criteria'];
		$companyId = $_GET['companyId'];
		if ($criteria == 'year') {
			if (isset($_GET['year']) && $_GET['year'] < 9999 && $_GET['year'] > 1111) {
				$year = $_GET['year'];
				$criteriaText = 'Year';
				$lastYear = $year - 1;
				$reportDuration = $year - 1 ." - ". substr($year, 2);
				$condition =  "WHERE companyId = $companyId AND paymentDate BETWEEN '$lastYear-04-01' AND '$year-03-31'";
				$sql = "SELECT * FROM `payments` $condition ORDER BY paymentDate ASC";
			}
			else{
				die("Invalid Year Provided");
			}
		}
		elseif ($criteria == 'month') {
			if (isset($_GET['month']) && isset($_GET['year']) && $_GET['year'] < 9999 && $_GET['year'] > 1111 && $_GET['month'] < 13 && $_GET['month'] > 0) {
				$month = $_GET['month'];
				$year = $_GET['year'];
				$criteriaText = 'Month';
				$reportDuration = $monthArray[$month]." - ".$year;
				$condition = "WHERE companyId = $companyId AND MONTH(paymentDate) = '$month' AND YEAR(paymentDate) = '$year'";
				$sql = "SELECT * FROM `payments` $condition ORDER BY paymentDate ASC";
			}
			else{
				die("Invalid Month / Year Provided");
			}
		}
		elseif ($criteria == 'date') {
			if (isset($_GET['from']) && isset($_GET['to'])) {
				$from = $_GET['from'];
				$to = $_GET['to'];
				$criteriaText = 'Report Duration';
				$reportDuration = date('d-M-y', strtotime($from))." To ".date('d-M-y', strtotime($to));
				$condition = "WHERE companyId = $companyId AND paymentDate BETWEEN '$from' AND '$to'";
				$sql = "SELECT * FROM `payments` $condition ORDER BY paymentDate ASC";
			}
			else{
				die("Invalid Month / Year Provided");
			}
		}
		else{
			die("Invalid Report criteria: Possible Values are year | month | date");
		}
	}
	else{
		die("Can't Generate Report Without Parameters");
	}
	$companyData = mysqli_fetch_assoc(mysqli_query($con, "SELECT name, gstin from companies where id = $companyId"));
	$totalPaymentAmount = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(paymentAmount) as totalPayment FROM `payments` $condition"))['totalPayment'];
	$result = mysqli_query($con, $sql);
	$totalPayments = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $companyData['name']; ?> - Payments - <?php echo $criteriaText." ".$reportDuration; ?></title>
	<style>
		*{font-family: "Montserrat", sans-serif;}
		body{
			padding: 0px 50px;
		}
		.center{text-align: center;}
		.right{text-align: right;}
		table{ border-collapse: collapse; }
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
		button:focus{
			box-shadow: 0 0 10px #000;
		}
		button:active{
			box-shadow: none;
		}
	</style>
</head>
<body>
	<h1 align="center">All Payments / <?php echo $companyData['name']; ?> / <?php echo $reportDuration; ?></h1>
	<table border="0" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Company Name</th>
			<td class="center"><?php echo $companyData['name']; ?></td>
			<th>GSTIN</th>
			<td class="center"><?php echo $companyData['gstin']; ?></td>
			<th><?php echo $criteriaText; ?></th>
			<td class="center">
				<?php echo $reportDuration; ?>	
			</td>
			<th>Total Payment Amount</th>
			<td class="center"><?php echo "Rs. ". number_format($totalPaymentAmount); ?></td>
		</tr>
	</table>
	<br>
	<?php if ($totalPayments > 0): ?>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Bill Number</th>
			<th>Payment Date</th>
			<th>Amount</th>
			<th>Payment Mode</th>
			<th width="30%">Description</th>
		</tr>
		<?php
			$serial = 1; 
			for ($i=0; $i < $totalPayments; $i++) { 
				$data = mysqli_fetch_assoc($result);
				$paymentDate = date('d-M-y', strtotime($data['paymentDate']));
				$mode = $data['modeOfPayment'];
				$paidBills = json_decode($data['paidBills'], true);
				for ($j=0; $j < count($paidBills); $j++) { 
					$billNumber = $paidBills[$j]['invoice'];
					$amount = $paidBills[$j]['amt'];
					$description = $data['description'];
			?>
				<tr>
					<td class="center"><?php echo $serial++; ?></td>
					<td class="center"><?php echo $billNumber; ?></td>
					<td class="center"><?php echo $paymentDate; ?></td>
					<td class="right"><?php echo "Rs. ".number_format($amount); ?></td>
					<td class="center"><?php echo $mode; ?></td>
					<td><?php echo $description; ?></td>
				</tr>
			<?php } // Loop $j ?>
		<?php } // Loop $i ?>
	</table>
	<br>
	<button id="printBtn">Print</button>
	<footer>
		<script>
			printBtn = document.querySelector('#printBtn')
			printBtn.addEventListener('click', function () {
				printBtn.style.display = 'none'
				document.body.style.padding = '0px'
				window.print()
			})
			window.addEventListener('afterprint', function () {
				document.body.style.padding = '0 50px'
				printBtn.style.display = 'block'
			})
		</script>
	</footer>
	<?php endif ?>
</body>
</html>