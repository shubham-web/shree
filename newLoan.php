<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT id, name FROM `employees` ORDER BY name asc';
	$execute = mysqli_query($con, $sql);
	$totalEmployees = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Add Loan Entry</title>
	<link rel="stylesheet" href="css/addGatepass.css" />
	<link rel="stylesheet" href="css/msgBox" />
</head>
<body>
<form>
<img src="icon/back" alt="Back" id="backIcon" />
<table border="0">
	<thead>
		<tr>
			<td colspan="2">
				<h1 id="formHeading">Loan Entry</h1>
			</td>
		</tr>
	</thead>
	<tbody id="tbody">
		<tr>
			<td>Loan Date</td>
			<td><input type="date" name="date" id="date" /></td>
		</tr>
		<tr>
			<td>Employee Name</td>
			<td>
				<select id="name">
					<option value="">---Select Employee---</option>
					<?php 
						for ($i=0; $i < $totalEmployees; $i++) { 
							$data = mysqli_fetch_assoc($execute);
							$name = $data['name'];
					?>
					<option value="<?php echo $data['id']; ?>"><?php echo $name; ?></option>
					<?php }// For Loop	?>
				</select>
				<input type="text" disabled="" id="employeeId" value="#ID" title="Employee ID" size="1" />
			</td>
		</tr>
		<tr>
			<td>Due Before Today</td>
			<td><input type="text" id="totalDue" class="amountInput" disabled="" placeholder="0" /></td>
		</tr>
		<tr>
			<td>Loan Taken</td>
			<td><input type="text" id="taken" autocomplete="off" class="amountInput" placeholder="Amount" value="0" /></td>
		</tr>
		<tr>
			<td>Loan Returned</td>
			<td><input type="text" id="returned" autocomplete="off" class="amountInput" placeholder="Amount" value="0" /></td>
		</tr>
		<tr>
			<td>Due After Today</td>
			<td><input type="text" id="totalDueAfterToday" class="amountInput" disabled="" placeholder="0" /></td>
		</tr>
		<tr><td colspan="2"><button type="submit" id="saveBtn">Save</button></td></tr>
	</tbody>
</table>
</form>
<span id="message"></span>
<footer>
	<script src="js/loanEntry.js"></script>
</footer>
</body>
</html>