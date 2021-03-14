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
	$sales = mysqli_fetch_assoc(mysqli_query($con, "SELECT  SUM(billAmount) as taxableValue,SUM(sgst) as sgst,SUM(cgst) as cgst, SUM(igst) as igst FROM `bills` WHERE MONTH(billDate)  = $month AND YEAR(billDate) = $year AND billStatus = 1"));
	$purchase = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount) as taxableValue, SUM(igst) as igst, SUM(sgst) as sgst, SUM(cgst) as cgst FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year"));
	function emptyThenZero($amount){
		return ($amount == '') ? 0 : number_format(round($amount, 2));
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $monthArray[$month-1]."-".$year; ?></title>
	<style>
		*{
			box-sizing: border-box;
			font-family: "Montserrat", sans-serif;
		}
		body{
			margin: 0;
			padding: 0px;
			width: 100%;
		}
		table{
			border-collapse: collapse;
			border-color: #ccc; 
			margin-bottom: 20px;
		}
		.head{
			background-color: #f1f1f1;
			font-weight: bold;
		}
		td{
			padding: 10px;
			text-align: center;
		}
		.left{
			text-align: left;
		}
		.right{
			text-align: right;
		}
		.bold{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<table border="1" width="100%">
		<thead class="head">
			<tr>
				<td colspan="4"><?php echo $monthArray[$month-1]."-".$year; ?></td>
			</tr>
			<tr>
				<td colspan="2">SALES</td>
				<td colspan="2">PURCHASE</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Total Taxable Value</td>
				<td><?php echo emptyThenZero($sales['taxableValue']); ?></td>
				<td class="left">Total Taxable Value</td>
				<td><?php echo emptyThenZero($purchase['taxableValue']); ?></td>

			</tr>
			<tr>
				<td class="left">Total CGST</td>
				<td><?php echo emptyThenZero($sales['cgst']); ?></td>
				<td class="left">Total CGST</td>
				<td><?php echo emptyThenZero($purchase['cgst']); ?></td>
			</tr>
			<tr>
				<td class="left">Total SGST</td>
				<td><?php echo emptyThenZero($sales['sgst']); ?></td>
				<td class="left">Total SGST</td>
				<td><?php echo emptyThenZero($purchase['sgst']); ?></td>
			</tr>
			<tr>
				<td class="left">Total IGST</td>
				<td><?php echo emptyThenZero($sales['igst']); ?></td>
				<td class="left">Total IGST</td>
				<td><?php echo emptyThenZero($purchase['igst']); ?></td>
			</tr>
			<tr>
				<?php 
					$totalSalesTax = $sales['cgst'] + $sales['sgst'] + $sales['igst'];
					$totalPurchaseTax = $purchase['cgst'] + $purchase['sgst'] + $purchase['igst'];
				?>
				<td class="bold" colspan="2">Payable Tax (<?php echo $totalSalesTax." - ". $totalPurchaseTax; ?>)</td>
				<td colspan="2" class="bold"><?php echo number_format($totalSalesTax - $totalPurchaseTax); ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>