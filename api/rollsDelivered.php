<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (isset($_GET['year']) && isset($_GET['month'])) {
		$year = $_GET['year'];
		$month = $_GET['month'];
	}
	else{
		die('Invalid Request');
	}
	$monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	$sql = "SELECT * FROM `chalans` WHERE YEAR(date) = $year && MONTH(date) = $month";
	$result = mysqli_query($con, $sql);
	$totalChalans = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Delivered Rolls - <?php echo $monthArray[$month-1]." ".$year; ?></title>
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
	<h1 align="center">Delivered Rolls - <?php echo $monthArray[$month-1]." ".$year; ?></h1>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th width="5%">Sr. no</th>
			<th width="10%">Chalan Number</th>
			<th width="15%">Chalan Date</th>
			<th width="25%">Company Name</th>
			<th width="10%">Quantity</th>
			<th width="35%">Description</th>
		</tr>
		<?php 
			for ($i=0; $i < $totalChalans; $i++) { 
				$data = mysqli_fetch_assoc($result);
				$date = date('d-M-y', strtotime($data['date']));
				$cId = $data['companyId'];
				$company = mysqli_fetch_assoc(mysqli_query($con, "SELECT name from companies where id = $cId"))['name'];
				$rollsInfo = json_decode($data['rollsInfo']);
		?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo $data['number']; ?></td>
			<td><?php echo $date; ?></td>
			<td><?php echo $company; ?></td>
			<td colspan="2">
				<table cellspacing="0" cellpadding="5" width="100%">
					<?php 
						for ($j=0; $j < count($rollsInfo); $j++) { 
					?>
					<tr>
						<td width="25%"><?php echo $rollsInfo[$j][0]; ?></td>
						<td width="75%"><?php echo $rollsInfo[$j][1]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>

		<?php } // For Loop	?>
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