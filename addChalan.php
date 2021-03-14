<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Add Chalan</title>
	<link rel="stylesheet" href="css/addBill.css" />
	<link rel="stylesheet" href="css/snackbar.css" />
</head>
<body>
<form>
<img src="icon/back" id="backIcon" />
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">New Chalan</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td class="fieldName">Chalan Date</td>
			<td class="fieldInput"><input type="date" value="2018-11-22" id="chalanDate"></td>
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
			<td class="fieldName">Gatepass Number</td>
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
			<td colspan="2" id="rollsInfoWrapper">
				<button id="viewRollsBtn" class="action">View Rolls Info</button>
				<fieldset id="rollsInfo">
					<legend>Rolls Info</legend>
						<table border="0" id="rollInfoTable">
							<thead>
								<tr>
									<th></th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Delivered Rolls</th>
								</tr>
							</thead>
							<tbody id="rollBody"></tbody>
						</table>
					<button id="createChalan" class="action">Print Chalan</button>
				</fieldset>
			</td>
		</tr>
	</tbody>
</table>
</form>

<span id="message"></span>

<footer>
	<script src="js/addChalan.js"></script>
</footer>
</body>
</html>