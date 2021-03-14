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
				$sql = "SELECT * FROM `bills` WHERE companyId = $companyId AND billDate BETWEEN '$lastYear-04-01' AND '$year-03-31' ORDER BY billDate ASC";
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
				$sql = "SELECT * FROM `bills` WHERE companyId = $companyId AND MONTH(billDate) = '$month' AND YEAR(billDate) = '$year' ORDER BY billDate ASC";
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
				$sql = "SELECT * FROM `bills` WHERE companyId = $companyId AND billDate BETWEEN '$from' AND '$to' ORDER BY billDate ASC";
			}
			else{
				die("Invalid Month / Year Provided");
			}
		}
	}
	else{
		die("Can't Generate Report Without Parameters");
	}
	$companyData = mysqli_fetch_assoc(mysqli_query($con, "SELECT name, gstin from companies where id = $companyId"));
	$result = mysqli_query($con, $sql);
	$totalBills = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $companyData['name']; ?> - All Bills - <?php echo $criteriaText." ".$reportDuration; ?></title>
	<style>
		*{font-family: "Montserrat", sans-serif;}
		body{
			padding: 0px 20px;
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
	<h1 align="center">All Bills / <?php echo $companyData['name']; ?> / <?php echo $reportDuration; ?></h1>
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
			<th>Total Bills</th>
			<td class="center"><?php echo $totalBills; ?></td>
		</tr>
	</table>
	<br>
	<?php if ($totalBills > 0): ?>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Bill Number</th>
			<th>Bill Date</th>
			<th>Taxable Value</th>
			<?php 
				$pos = strpos($companyData['gstin'], '23');
				if ($pos === 0) { // From MP
			?>
			<th>SGST</th>
			<th>CGST</th>
			<?php
				} else{ 
			?>
			<th>IGST</th>
			<?php 	} ?>
			<th>Invoice Value</th>
			<th>Paid Amount</th>
			<th>Remarks</th>
			<th>Status</th>
		</tr>
		<?php 
			for ($i=0; $i < $totalBills; $i++) { 
				$data = mysqli_fetch_assoc($result);
				$number = $data['billNumber'];
				$date = date('d-M-y', strtotime($data['billDate']));
		?>
		<tr>
			<td class="center"><?php echo $i+1; ?></td>
			<td class="center"><?php echo $number; ?></td>
			<td class="center"><?php echo $date; ?></td>
			<td class="right"><?php echo $data['billAmount']; ?></td>
			
			<?php 
				$pos = strpos($companyData['gstin'], '23');
				if ($pos === 0) { // From MP
			?>
			<td class="right"><?php echo $data['sgst']; ?></td>
			<td class="right"><?php echo $data['cgst']; ?></td>
			<?php
				} else{ 
			?>
			<td class="right"><?php echo $data['igst']; ?></td>
			<?php 	} ?>

			<td><?php echo "Rs. ". number_format($data['billTotal']); ?></td>




			<?php
				$statement = mysqli_query($con, "SELECT paymentDate, paidBills, description FROM `payments` WHERE paidBills LIKE '%$number%'");
				$paymentRows = mysqli_num_rows($statement);
				for ($j=0; $j < $paymentRows; $j++) { 
					if ($j==0) echo "<td>";
					$paymentData = mysqli_fetch_object($statement);
					$paymentDate = date('d-M-y', strtotime($paymentData->paymentDate));
					$paidBillsArray = json_decode($paymentData->paidBills, true);
					for ($k=0; $k < count($paidBillsArray); $k++) { 
						if ($paidBillsArray[$k]['invoice'] == $number) {
							echo "Rs. ";
							echo number_format($paidBillsArray[$k]['amt']);
							echo "( ".$paymentDate." ) ";
							echo "<br>";
						}
					}
					if ($j == $paymentRows -1 ) echo "</td>"; 
				}
			?>
			<td>
				<?php echo $paymentData->description; ?>
				
			</td>


			<td class="center">
				<?php 
					$paymentStts = 'Payment Pending';
					if ($data['paymentStts'] == '2') $paymentStts = 'Paid';
					elseif($data['paymentStts']) $paymentStts = 'Partially Paid';
					echo $paymentStts;
				?>
			</td>

		</tr>
		<?php } // For loop $i ?>
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
				document.body.style.padding = '0 20px'
				printBtn.style.display = 'block'
			})
		</script>
	</footer>
	<?php endif ?>
</body>
</html>