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
				$sql = "SELECT * FROM `gatepasses` WHERE companyId = $companyId AND gatepassDate BETWEEN '$lastYear-04-01' AND '$year-03-31' ORDER BY gatepassDate ASC";
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
				$sql = "SELECT * FROM `gatepasses` WHERE companyId = $companyId AND MONTH(gatepassDate) = '$month' AND YEAR(gatepassDate) = '$year' ORDER BY gatepassDate ASC";
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
				$sql = "SELECT * FROM `gatepasses` WHERE companyId = $companyId AND gatepassDate BETWEEN '$from' AND '$to' ORDER BY gatepassDate ASC";
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
	$result = mysqli_query($con, $sql);
	$totalGatepasses = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $companyData['name']; ?> - All Gatepass - <?php echo $criteriaText." ".$reportDuration; ?></title>
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
	<h1 align="center">All Gatepasses / <?php echo $companyData['name']; ?> / <?php echo $reportDuration; ?></h1>
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
			<th>Total Gatepasses</th>
			<td class="center"><?php echo $totalGatepasses; ?></td>
		</tr>
	</table>
	<br>
	<?php if ($totalGatepasses > 0): ?>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th width="5%">Sr. no</th>
			<th width="10%">GatePass Number</th>
			<th width="15%">GatePass Date</th>
			<th width="10%">Quantity</th>
			<th width="35%">Description</th>
		</tr>
		<?php 
			for ($i=0; $i < $totalGatepasses; $i++) { 
				$data = mysqli_fetch_assoc($result);
				$number = $data['gatepassNumber'];
				$date = date('d-M-y', strtotime($data['gatepassDate']));
				$rollsInfo = json_decode($data['rollsInfo'], true);
		?>
		<tr>
			<td class="center"><?php echo $i+1; ?></td>
			<td class="center"><?php echo $number; ?></td>
			<td><?php echo $date; ?></td>
			<td colspan="2">
				<table cellspacing="0" cellpadding="5" width="100%">
					<?php 
						for ($j=0; $j < count($rollsInfo); $j++) { 
							$qty = $rollsInfo[$j]['quantity'];
							$desc = $rollsInfo[$j]['description'];
					?>
					<tr>
						<td width="25%"><?php echo $qty; ?></td>
						<td width="75%"><?php echo $desc; ?></td>
					</tr>
					<?php } ?>
				</table>
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