<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT id, name FROM `vendors` order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalVendors = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Add Expenses</title>
	<link rel="stylesheet" href="css/addGatepass.css" />
	<link rel="stylesheet" href="css/snackbar.css" />
</head>
<body>
<form>
<img src="icon/back" id="backIcon" />
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Add Expenses</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td>Invoice Number</td>
			<td><input type="text" id="invoiceNumber" placeholder="Invoice Number" /></td>
		</tr>
		<tr>
			<td>Purchase Date</td>
			<td><input type="date" name="date" id="date" /></td>
		</tr>
		<tr>
			<td>Vendor Name</td>
			<td>
				<select name="vendorName" id="vId">
					<option value="">---Select Vendor---</option>
					<?php 
						for ($i=0; $i < $totalVendors; $i++) { 
							$data = mysqli_fetch_assoc($execute);
					?>
					<option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
					<?php
						}
					?>
				</select>
				<input type="text" disabled="" id="companyId" value="#ID" title="Vendor's ID" size="1" />
			</td>
		</tr>

		<tr>
			<td>Amount</td>
			<td>
				<input type="text" placeholder="Payment Amount" id="amount" autocomplete="off" />
			</td>
		</tr>
		<tr>
			<td>Tax (%)</td>
			<td>
				<input type="text" placeholder="Tax in Percentage" id="taxPercentage" autocomplete="off" />
			</td>
		</tr>
		<tr>
			<td>Total</td>
			<td>
				<input type="text" placeholder="Total Amount" id="totalAmount" disabled="" />
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input type="text" placeholder="Optional" id="description" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="submit" id="saveExpenses">Save</button>
			</td>
		</tr>

	</tbody>
</table>
</form>
<span id="message"></span>	
<footer>
	<script src="js/addExpenses.js"></script>
</footer>
</body>
</html>