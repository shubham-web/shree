<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	if (!isset($_GET['id'])) die("Invalid Request");
	$expensesId = $_GET['id'];
	$fetchPurchase = "SELECT * FROM `expenses` WHERE id = $expensesId";
	$executePurchase = mysqli_query($con, $fetchPurchase);
	$purchase = mysqli_fetch_assoc($executePurchase);

	$sql = 'SELECT id, name FROM `vendors` order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalVendors = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Update Expenses</title>
	<link rel="stylesheet" href="../css/addGatepass.css" />
	<link rel="stylesheet" href="../css/snackbar.css" />
</head>
<body>
<form>
<img src="../icon/back" id="backIcon" />
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Modify Purchase Details</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td>Invoice Number</td>
			<td><input type="text" id="invoiceNumber" placeholder="Invoice Number" value="<?php echo $purchase['invoiceNumber']; ?>" /></td>
		</tr>
		<tr>
			<td>Purchase Date</td>
			<td>
				<input type="date" name="date" id="date" value="<?php echo $purchase['date']; ?>" />
				<input type="hidden" id="purchaseId" value="<?php echo $purchase['id']; ?>" />
			</td>
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
					<option <?php echo ($purchase['vendorId'] === $data['id']) ? 'selected':''; ?> value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
					<?php } // For loop ?>
				</select>
				<input type="text" disabled="" id="companyId" value="#<?php echo $purchase['vendorId']; ?>" title="Vendor's ID" size="1" />
			</td>
		</tr>

		<tr>
			<td>Amount</td>
			<td>
				<input type="text" placeholder="Payment Amount" id="amount" value="<?php echo $purchase['amount']; ?>" autocomplete="off" />
			</td>
		</tr>
		<tr>
			<td>Tax (%)</td>
			<td>
				<input type="text" placeholder="Tax in Percentage" id="taxPercentage" autocomplete="off" value="<?php echo $purchase['taxPercentage']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Total</td>
			<td>
				<input type="text" placeholder="Total Amount" id="totalAmount" disabled="" value="<?php echo $purchase['total']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input type="text" placeholder="Optional" id="description" value="<?php echo $purchase['description']; ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="submit" id="saveExpenses">Update</button>
			</td>
		</tr>

	</tbody>
</table>
</form>
<span id="message"></span>	
<footer>
	<script src="../js/updateExpenses.js"></script>
</footer>
</body>
</html>