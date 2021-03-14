<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$gatepassId = $_GET['id'];
	$fetchGatepass = "SELECT * FROM `gatepasses` WHERE id = $gatepassId";
	$gatepass = mysqli_fetch_assoc(mysqli_query($con, $fetchGatepass));
	$rollsInfo = json_decode($gatepass['rollsInfo'], true);

	$sql = 'SELECT id, name FROM `companies` ORDER BY name asc';
	$execute = mysqli_query($con, $sql);
	$totalCompanies = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Modify Gatepass</title>
	<link rel="stylesheet" href="../css/addGatepass.css" />
	<link rel="stylesheet" href="../css/snackbar.css" />
</head>
<body>
<form>
<img src="../icon/back" alt="" id="backIcon">
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Modify Gatepass</h1> 
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td>Company Name</td>
			<td>
				<select name="companyName" id="name">
					<option value="">---Select Company---</option>
					<?php 
						for ($i=0; $i < $totalCompanies; $i++) { 
							$data = mysqli_fetch_assoc($execute);
							$cName = str_replace(" And ", "&", $data['name']);
					?>
					<option <?php echo ($gatepass['companyId'] === $data['id'])? 'selected':''; ?> value="<?php echo $data['id']; ?>"><?php echo $cName; ?></option>
					<?php }// For Loop	?>
				</select>
				<input type="text" disabled="" id="companyId" value="#<?php echo $gatepass['companyId'] ?>" title="Company ID" size="1" />
				<a href="../newCompany">Add Company</a>
			</td>
		</tr>

		<tr>
			<td>Gatepass Number</td>
			<td>
				<input type="text" id="gatepassNumber" value="<?php echo $gatepass['gatepassNumber']; ?>" />
				<input type="hidden" id="gatepassId" value="<?php echo $gatepass['id']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Gatepass Date</td>
			<td><input type="date" name="date" id="date" value="<?php echo $gatepass['gatepassDate']; ?>" /></td>
		</tr>
		<tr>
			<td>Status</td>
			<td>
				<input type="radio" name="status" id="Pending" <?php echo ($gatepass['status'] === 'Pending') ? 'checked':''; ?> />
				<label for="Pending">Pending</label>
				<input type="radio" name="status" id="Delivered" <?php echo ($gatepass['status'] === 'Delivered')? 'checked': ''; ?> />
				<label for="Delivered">Delivered</label>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<fieldset id="rollsInfo">
					<legend>Particulars Info</legend>
						<table style="width: 100%;" border="0">
							<thead>
								<tr>
									<th>#</th>
									<th>Quantity</th>
									<th colspan="2">Description</th>
								</tr>
							</thead>
							<tbody id="rollBody">
								<?php
									for ($i=0; $i < count($rollsInfo); $i++) { 
										$qty = $rollsInfo[$i]['quantity'];
										$desc = $rollsInfo[$i]['description'];
								?>
								<tr class="rowToCopy">
									<td class="serialNumber">1</td>
									<td><input type="number" min="1" class="quantity" value="<?php echo $qty; ?>" placeholder="Quantity" /></td>
									<td><input type="text" class="description" value="<?php echo $desc; ?>" placeholder="Description" /></td>
									<td><button class="removeBtn">Remove</button></td>
								</tr>
								<?php } // For Loop ?>
							</tbody>
						</table>
						<button id="addRowBtn">Add Roll</button>
				</fieldset>
				<button type="submit">Save</button>
		</tr>
	</tbody>
</table>
</form>
<span id="message"></span>	
<footer>
	<script src="../js/modifyGatepass.js"></script>
</footer>
</body>
</html>