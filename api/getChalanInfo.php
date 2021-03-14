<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	isset($_GET['number']) or die("Invalid Request");
	$chalanNumber = $_GET['number'];

	$sql = "SELECT * FROM `chalans` WHERE number = $chalanNumber";
	$result = mysqli_query($con, $sql);
	$chalan = mysqli_fetch_assoc($result);
	$date = strtotime($chalan['date']);
	$date = date("d-M-y", $date);
	$rollsInfo = json_decode($chalan['rollsInfo']);
?>
<tr>
	<td>Chalan Number</td>
	<td><?php echo $chalan['number']; ?></td>
</tr>
<tr>
	<td>Date</td>
	<td><?php echo $date; ?></td>
</tr>
<tr>
	<td>Gatepass Number</td>
	<td><?php echo $chalan['gatepassNumber']; ?></td>
</tr>
<tr>
	<td>Vehicle Number</td>
	<td><?php echo $chalan['vehicleNumber']; ?></td>
</tr>
<tr>
	<td colspan="2">
		<fieldset>
			<legend style="text-align: center;">Particulars</legend>
			<table width="100%">
				<tr>
					<th>Quantity</th>
					<th>Description</th>
				</tr>
				<?php for ($i=0; $i < count($rollsInfo); $i++) { ?>
					<tr>
						<td><?php echo $rollsInfo[$i][0]; ?></td>
						<td><?php echo $rollsInfo[$i][1]; ?></td>
					</tr>
				<?php } // Loop ?>
			</table>
		</fieldset>
	</td>
</tr>