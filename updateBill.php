<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$billNumber = $_GET['billNumber'];
	$billData = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `bills` WHERE billNumber = '$billNumber'"));
	$companyId = $billData['companyId'];
	$gatepassNumber = $billData['gatepassNumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Update Bill</title>
	<link rel="stylesheet" href="../css/addBill.css" />
	<link rel="stylesheet" href="../css/snackbar.css" />
	<base href="../">
</head>
<body>
<form>
<img src="icon/back" id="backIcon">
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Update Bill</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td class="fieldName" valign="top">Bill Number</td>
			<td class="fieldInput"><b id="billNumber"><?php echo $billData['billNumber']; ?></b></td>
		</tr>
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
			<td class="fieldName">Bill Date</td>
			<td class="fieldInput"><input type="date" id="billDate"></td>
		</tr>
		<tr>
			<td class="fieldName">Company Name</td>
			<td class="fieldInput">
				<select id="companyId">
					<option value="">---Select Company---</option>
					<?php 
						$sql = 'SELECT id, name, gstin FROM `companies` order by name asc';
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
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2" id="chalanInfoWrapper">
				<fieldset id="chalanInfo">
					<legend>Chalan Details</legend>
						<table border="0" id="chalanInfoTable">
							<thead>
								<tr>
									<th>Description</th>
									<th>Quantity</th>
									<th>Date</th>
									<th>Chalan Number</th>
								</tr>
							</thead>
							<tbody id="chalanBody">
							</tbody>
						</table>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td colspan="2" id="rollsInfoWrapper">
				<button id="viewRollsBtn" class="action">Continue</button>
				<fieldset id="rollsInfo">
					<legend>Rolls Info</legend>
						<table border="0" id="rollInfoTable">
							<thead>
								<tr>
									<th></th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Delivered Rolls</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody id="rollBody"></tbody>
						</table>
					<a href="editBill/<?php echo $billNumber; ?>#chalanInfoWrapper" id="chalanLink">View Chalan Details</a>
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
<input type="hidden" id="oldCID" value="<?php echo $companyId; ?>" />
<input type="hidden" id="oldGPN" value="<?php echo $gatepassNumber; ?>" />
<button id="createBill" class="action">Update & Print Bill</button>
</form>

<span id="message"></span>
<audio src="sounds/notify.mp3" id="notifySound"></audio>
<footer>
	<script src="js/updateBill.js"></script>
</footer>
</body>
</html>