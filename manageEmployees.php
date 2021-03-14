<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT * FROM employees order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalEmployees = mysqli_num_rows($execute);
	$placeholder = "Search";
	if ($totalEmployees > 10)
		$placeholder = 'Search Over '.$totalEmployees.' Employees';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<link rel="stylesheet" href="css/popup" />
	<title>Manage Employees</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="25%"><button id="addNewBtn">Add Employee</button></td>
				<td align="left" width="25%"><button id="reportBtn">Manage Salary</button></td>
				<td align="left" width="25%"><button id="reportBtn2">Manage Advance</button></td>
				<td align="right"  width="25%" class="p_a">
					<input type="text" placeholder="<?php echo $placeholder; ?>" autofocus id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" />
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
			<th>Qualification</th>
			<th>Contact</th>
			<th>Joining Date</th>
			<th style="text-align: center;">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalEmployees; $i++) { 
				$data = mysqli_fetch_assoc($execute);
				if ($data['joiningDate'] == '0000-00-00') {
					$date = '<small>Not Provided</small>';
				}
				else{
					$date = date('d-M-y', strtotime($data['joiningDate']));
				}
		?>
		<tr>
			<td title="Serial Number"><?php echo $i+1; ?></td>	
			<td class="name" title=""><?php echo $data['name']; ?></td>
			<td class="qualification" title=""><?php echo $data['qualification']; ?></td>
			<td class="contact" title=""><?php echo $data['mobileNumber']; ?></td>	
			<td class="date" title=""><?php echo $date; ?></td>	
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="view(<?php echo $data['id']; ?>)" title="View Employee Details">
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
				<button class="editBtn" onclick="edit(<?php echo $data['id']; ?>)" title="Edit Employee Details">
					<img src="img/icon/edit.png" alt="Edit Icon" class="btnIcon" />
				</button>
				<button class="deleteBtn" onclick="del(<?php echo $data['id']; ?>)" title="Delete Employee">
					<img src="img/icon/delete.png" alt="Delete Icon" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php } // For Loop ?>
	</tbody>
	</table>
	<?php } // if of total employees
		else{
			echo "<h3>Nothing to Show</h3>";
			echo "<small>Press Alt + N or Click on Add Employee Button to Add Employee</small>";
		}
	 ?>

	 <button id="view" hidden>View Employee Details</button>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table">
				<thead><tr><td colspan="2"><h1>Employee Details</h1></td></tr></thead>
				<tbody id="employeeDetails"></tbody>
			</table>
		</div>	
	</div>
	<footer>
		<script src="js/manageEmployees.js"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>