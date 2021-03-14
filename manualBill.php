<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$lastBillNumber = mysqli_fetch_assoc(mysqli_query($con, "SELECT billNumber FROM `bills` WHERE id = (SELECT MAX(id) FROM `bills`)"))['billNumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Create Manual Bill</title>
	<link rel="stylesheet" href="css/addBill.css" />
	<link rel="stylesheet" href="css/snackbar.css" />
</head>
<body>
<form>
<img src="icon/back" id="backIcon">
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Generate Manual Bill</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td class="fieldName">HSN Code</td>
			<td class="fieldInput">
				<input type="radio" name="hsnCode" checked="" id="hsn1">
				<label for="hsn1">8455</label>
				<input type="radio" name="hsnCode" id="hsn2">
				<label for="hsn2">8456</label>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Bill Number</td>
			<td class="fieldInput"><input type="text" autocomplete="off" placeholder="Bill Number" id="billNumber">	
				<?php
					if ($lastBillNumber != "") {
						echo "<span title=\"Last Bill Number  --Double Click to Auto Fill Bill Number--\" id=\"lastBillNumber\"> ";
						echo $lastBillNumber;
						echo "</span>";
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Bill Date</td>
			<td class="fieldInput"><input type="date" id="billDate"></td>
		</tr>
		<tr>
			<td class="fieldName">Company Name</td>
			<td class="fieldInput">
				<select id="companyId">
					<option value="">---Select Company---</option>
					<?php 
						$sql = 'SELECT id, name, gstin FROM `companies` ORDER BY name asc';
						$execute = mysqli_query($con, $sql);
						$companies = mysqli_num_rows($execute);
						for ($i=0; $i < $companies; $i++) { 
							$data = mysqli_fetch_assoc($execute);
					?>
						<option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
					<?php } // For Loop	?>
				</select>
				<input type="text" disabled="" id="cid" value="#ID" title="Company ID" size="1" />
			</td>
		</tr>

		<tr>
			<td class="fieldName">Choose Gatepass Number</td>
			<td class="fieldInput">
				<select id="gatepassNumber" disabled="">
					<option value="">---Select Company First---</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="fieldName">Vehicle Number</td>
			<td class="fieldInput">
				<input type="text" placeholder="Optional" id="vehicleNumber" autocomplete="off" />
			</td>
		</tr>
		<tr>
			<td colspan="2"><button id="viewRollsBtn" class="action">Continue</button></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2" id="step2" style="display: none; transform: scale(0);">
				<fieldset id="particularsInfo">
					<legend>Particulars Info</legend>
						<table style="width: 100%;" border="0">
							<thead>
								<tr>
									<td>#</td>
									<td>Quantity</td>
									<td>Description</td>
									<td colspan="2">Price</td>
								</tr>
							</thead>
							<tbody id="particularBody">
								<tr class="rowToCopy">
									<td class="serialNumber">1</td>
									<td><input type="number" min="1" class="quantity" placeholder="Quantity" /></td>
									<td><input type="text" class="description" placeholder="Description" /></td>
									<td><input type="text" class="price" placeholder="Price" /></td>
									<td><button class="removeBtn">Remove</button></td>
								</tr>
							</tbody>
						</table>
						<button id="addRowBtn">Add Row</button>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td colspan="2" id="addOnWrapper">
				<fieldset id="addOn">
					<legend> + / - </legend>
						<table border="0" id="addOnTable">
							<thead>
								<tr>
									<th></th>
									<th>Description</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody id="addOnBody">
								<tr>
									<td><input type="checkbox" id="incrementCheck" /></td>
									<td>
										<img src="img/icon/plus.png" class="icon" alt="increment">
										<input type="text" id="descInc" placeholder="Description" disabled />
									</td>
									<td><input type="text" id="priceInc" placeholder="Price" id="increment" disabled /></td>
								</tr>
								<tr>
									<td><input type="checkbox" id="decrementCheck" /></td>
									<td>
										<img src="img/icon/minus.png" class="icon" alt="Decrement">
										<input type="text" id="descDec" placeholder="Description" disabled />
									</td>
									<td><input type="text" id="priceDec" placeholder="Price" id="decrement" disabled /></td>
								</tr>
								<tr>
									<td><input type="checkbox" id="descriptionCheck" /></td>
									<td colspan="3" style="text-align: center;">
										<input type="text" style="width: 50%;" id="descriptionOnly" placeholder="Note" disabled />
									</td>
								</tr>
							</tbody>
						</table>
						<button id="calculate" class="action">Proceed</button>
				</fieldset>
			</td>
		</tr>
	</tfoot>
</table>
<table id="amountsTable">
	<tr>
		<td title="Total Amount (Before Tax)">Total Amount (Before Tax)</td>
		<td class="amounts" id="totalAmount">0</td>
	</tr>
	<tr>
		<td>CGST @ 9%</td>
		<td class="amounts" id="cgst">0</td>
	</tr>	
	<tr>
		<td>SGST @ 9%</td>
		<td class="amounts" id="sgst">0</td>
	</tr>
	<tr>
		<td>IGST @ 18%</td>
		<td class="amounts" id="igst">0</td>
	</tr>
	<tr>
		<td>Round off</td>
		<td class="amounts" id="roundOff"></td>
	</tr>
	<tr>
		<td>Net Amount</td>
		<td class="amounts" id="netAmount">0</td>
	</tr>
</table>
<button id="createBill" class="action">Save & Print Bill</button>
</form>

<span id="message"></span>
<audio src="sounds/notify.mp3" id="notifySound"></audio>
<footer>
	<script src="js/manualBill.js"></script>
</footer>
</body>
</html>