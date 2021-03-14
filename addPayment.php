<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT id, name FROM `companies` order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalCompanies = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Add Payment</title>
	<link rel="stylesheet" href="css/addGatepass.css" />
	<link rel="stylesheet" href="css/snackbar.css" />
</head>
<body>
<form>
<img src="icon/back" id="backIcon" />
<table border="0" width="80%">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Add Payment</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td>Payment Date</td>
			<td><input type="date" name="date" id="date" /></td>
		</tr>
		<tr>
			<td>Company Name</td>
			<td>
				<select name="companyName" id="cId">
					<option value="">---Select Company---</option>
					<?php 
						for ($i=0; $i < $totalCompanies; $i++) { 
							$data = mysqli_fetch_assoc($execute);
					?>
					<option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
					<?php } // loop ?>
				</select>
				<input type="text" disabled="" id="companyId" value="#ID" title="Company ID" size="1" />
			</td>
		</tr>
		<tr>
			<td>Payment Amount</td>
			<td>
				<input type="text" placeholder="Payment Amount" id="amount" autocomplete="off" />
			</td>
		</tr>
		<tr id="unpaidBillsRow">
			<td colspan="2">
				<fieldset>
					<legend id="legend"></legend>
					<table style="width: 100%;">
						<thead>
						<tr>
							<th></th>
							<th>Invoice</th>
							<th>Total</th>
							<th>Paid</th>
							<th>Due</th>
							<th>Recieved</th>
							<th>Status</th>
						</tr>
						</thead>
						<tbody id="pendingBillsBody"></tbody>
					</table>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>Mode of Payment</td>
			<td>
				<input type="radio" name="mode" id="CASH" />
				<label for="CASH">CASH</label>
				<input type="radio" name="mode" id="CHEQUE" checked />
				<label for="CHEQUE">CHEQUE</label>
				<input type="radio" name="mode" id="RTGS" />
				<label for="RTGS">RTGS</label>
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input type="text" placeholder="eg. Cheque Number" id="description" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="submit" id="savePayment" class="action">Save</button>
			</td>
		</tr>

	</tbody>
</table>
</form>
<span id="message"></span>	
<footer>
	<script src="js/newPayment"></script>
</footer>
</body>
</html>