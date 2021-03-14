<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect() or die("Database Connection Failed");
	$sql = "SELECT * FROM `advance` ORDER BY date DESC, id desc";
	$execute = mysqli_query($con, $sql);
	$rows = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<title>Manage Advance of Employees | Shree Engineering Works</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><img src="icon/back" id="backIcon" /><h1 class="left">Loans</h1></td>
				<td align="center" width="40%"><button id="addNewBtn">Add Entry</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="Search" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<?php if (!($rows == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Employee</th>
			<th>Loan Taken</th>
			<th>Loan Returned</th>
			<th>Due Till Date</th>
			<th style="text-align: center;">Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php
			for ($i=0; $i < $rows; $i++) { 
				$data = mysqli_fetch_assoc($execute);
				$date = date('d-M-y',strtotime($data['date']));
				$eId = $data['employeeId'];
				$employee = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `employees` where id = $eId"))['name'];
		?>
		<tr id="row_<?php echo $data['id']; ?>">
			<td title="Serial Number"><?php echo $i+1; ?></td>	
			<td class="date"><?php echo $date; ?></td>
			<td class="employeeNames"><?php echo $employee; ?></td>
			<td class="takenAmt">Rs. <?php echo number_format($data['takenAmt']); ?></td>
			<td class="returnedAmt">Rs. <?php echo number_format($data['returnedAmt']); ?></td>
			<td class="totalDue">Rs. <?php echo number_format($data['totalDue']); ?></td>
			<td class="actions" style="text-align: center;">
				<button class="deleteBtn" onclick="deleteEntry(<?php echo $data['id']; ?>)" title="Delete Entry">
					<img src="icon/delete" alt="Delete Icon" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php } // For Loop ?>
	</tbody>
	</table>
	<span id="ajaxMessages"></span>
	<?php } // if of total companies
		else{
			echo "<h3>Nothing to Show</h3>";
			echo "<small>Press Alt + N or Click on Add Entry Button to Create New Loan Entry</small>";
		}
	 ?>
	<footer>
		<script src="js/manageAdvance.js"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>