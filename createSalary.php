<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT id, name, salary FROM employees order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalEmployees = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<link rel="stylesheet" href="css/msgBox" />
	<title>Create Salary of Employees</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><img src="icon/back" alt="" id="backIcon" /></td>
				<td align="center" width="40%"><h1 class="left">Create Salary</h1></td>
				<td align="right"  width="30%">
					Salary Date: <input type="date" id="salaryDate" />
				</td>
			</tr>
		</table>
	</header>
	<?php if (!($totalEmployees == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Salary</th>
			<th>Working Days</th>
			<th>Calculated Salary</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalEmployees; $i++) { 
				$data = mysqli_fetch_assoc($execute);
		?>
		<tr>
			<td title="Serial Number"><?php echo $i+1; ?></td>	
			<td class="name" title="Employee's Name"><?php echo $data['name']; ?></td>
			<td class="salary" title="<?php echo $data['name'] ?>'s Per day salary"><?php echo $data['salary']; ?></td>
			<td title="Enter <?php echo $data['name']; ?>'s Working Days here">
				<input type="number" data-salary="<?php echo $data['salary']; ?>" class="workingDays" id="days_<?php echo $data['id']; ?>" min="0" />
			</td>	
			<td id="slr_<?php echo $data['id']; ?>" title="Salary * Working Days"></td>
		</tr>
		<?php } // For Loop ?>
		<tr>
			<td colspan="5" style="text-align: center;">
				<button id="addNewBtn">Create Salary</button>
			</td>
		</tr>
	</tbody>
	</table>
	<?php } // if of total employees
		else{
			echo "<h3>No Employees</h3>";
			echo "<small>Can't Create Salary Add Employees First</small>";
		}
	 ?>
	<span id="message"></span>
	<footer>
		<script src="js/createSalary.js"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>