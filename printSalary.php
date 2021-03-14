<?php 
	require_once 'api/middleware.php';
	require_once 'config.php';
	dbConnect();
	isset($_GET['date']) or die('Invalid Request');
	$date = $_GET['date'];

	$sql = "SELECT * FROM `salary` WHERE date = '$date'";
	$result = mysqli_query($con, $sql);
	$rows = mysqli_num_rows($result);
	boolval($rows) or exit("Salary Data Not Found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Salary Dated <?php echo date('d-M-Y', strtotime($date)); ?></title>
	<style>
		*{font-family: "Montserrat", sans-serif;}
		.center{text-align: center;}
		.right{text-align: right;}
		table{
			margin: 0 auto;
		}
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
	<h1 align="center">Salary <?php echo date('F-Y', strtotime($date)); ?></h1>
	<table align="right" cellpadding="10" cellspacing="0">
		<tr>
			<th>Salary Created On</th>
			<td><?php echo date('d-M-Y', strtotime($date)); ?></td>
		</tr>
	</table>
	<br>
	<table border="1" cellspacing="0" cellpadding="10" id="dataTable" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Employee Name</th>
			<th>Working Days</th>
			<th>Salary</th>
		</tr>
		<?php 
			for ($i=0; $i < $rows; $i++) {
				$data = mysqli_fetch_assoc($result);
				$eId = $data['employeeId'];
				$name = mysqli_fetch_assoc(mysqli_query($con, "SELECT name from employees where id = $eId"))['name'];
		?>
		<tr>
			<td class="center"><?php echo $i+1; ?></td>
			<td><?php echo $name; ?></td>
			<td class="center"><?php echo $data['workingDays']; ?></td>
			<td>Rs. <?php echo number_format($data['amount']); ?></td>
		</tr>
		<?php } // For Loop ?>
	</table>
	<br>
	<br>
	<button id="printBtn">Print</button>
	<footer>
		<script>
			printBtn = document.querySelector('#printBtn')
			printBtn.onclick = () => {
				printBtn.style.display = 'none'
				window.print()
			}
			window.onafterprint = () => 
			{
				printBtn.style.display = 'block'
			}
		</script>
	</footer>
</body>
</html>