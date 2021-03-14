<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT id, name FROM `companies` ORDER BY name asc';
	$execute = mysqli_query($con, $sql);
	$totalCompanies = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Add Gatepass</title>
	<link rel="stylesheet" href="css/addGatepass.css" />
	<link rel="stylesheet" href="css/msgBox" />
</head>
<body>
<form>
<img src="icon/back" alt="" id="backIcon">
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Gatepass Entry</h1>
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
							$cName = $data['name'];
					?>
					<option value="<?php echo $data['id']; ?>"><?php echo $cName; ?></option>
					<?php }// For Loop	?>
				</select>
				<input type="text" disabled="" id="companyId" value="#ID" title="Company ID" size="1" />
				<a href="newCompany">Add Company</a>
			</td>
		</tr>

		<tr>
			<td>Gatepass Number</td>
			<td><input type="text" id="gatepassNumber" /></td>
		</tr>
		<tr>
			<td>Gatepass Date</td>
			<td><input type="date" name="date" id="date" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<fieldset id="rollsInfo">
					<legend>Rolls Info</legend>
						<table style="width: 100%;" border="0">
							<thead>
								<tr>
									<th>#</th>
									<th>Quantity</th>
									<th colspan="2">Description</th>
								</tr>
							</thead>
							<tbody id="rollBody">
								<tr class="rowToCopy">
									<td class="serialNumber">1</td>
									<td valign="top"><input type="number" min="1" class="quantity" placeholder="Quantity" /></td>
									<td>
										<textarea rows="1" class="description" title="Press Ctrl + V to fill Common Description" placeholder="Description"></textarea>
									</td>
									<td><button class="removeBtn">Remove</button></td>
								</tr>
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
	<script src="js/addGatepass.js"></script>
</footer>
</body>
</html>