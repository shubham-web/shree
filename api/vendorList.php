<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbconnect() or die('Database Connection Failed');
	$result = mysqli_query($con, "SELECT * from `vendors` order by name asc");
	$rows = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Vendor's List</title>
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
	<h1 align="center">Vendors</h1>
	<table border="1" cellspacing="0" cellpadding="10" width="100%">
		<tr>
			<th>Sr. no</th>
			<th>Name</th>
			<th>GSTIN</th>
			<th>Address</th>
			<th>Description</th>
		</tr>
		<?php 
			for ($i=0; $i < $rows; $i++) { 
			$data = mysqli_fetch_assoc($result);
		?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo $data['name']; ?></td>
			<td><?php echo $data['gstin']; ?></td>
			<td><?php echo $data['address']; ?></td>
			<td><?php echo $data['description']; ?></td>
		</tr>
		<?php } // For Loop ?>
		
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