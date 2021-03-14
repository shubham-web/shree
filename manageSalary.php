<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = "SELECT date,AVG(workingDays) as averageWorkingDays, AVG(amount) as avgSalary, SUM(amount) as paid FROM `salary` GROUP BY date ORDER BY date DESC";
	$execute = mysqli_query($con, $sql);
	$salaries = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<title>Manage Salaries of Employees | Shree Engineering Works</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><img src="icon/back" id="backIcon" /><h1 class="left">Salaries</h1></td>
				<td align="center" width="40%"><button id="addNewBtn">Create Salary</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="Search" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<?php if (!($salaries == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Average Working Days</th>
			<th>Average Paid Amount</th>
			<th>Total Amount</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			for ($i=0; $i < $salaries; $i++) { 
				$data = mysqli_fetch_assoc($execute);
				$date = date('d-M-y',strtotime($data['date']));
		?>
		<tr id="row_<?php echo $data['date']; ?>">
			<td title="Serial Number"><?php echo $i+1; ?></td>	
			<td class="date" title=""><?php echo $date; ?></td>
			<td class="avgDays" title=""><?php echo round($data['averageWorkingDays']); ?></td>
			<td class="avgSalary" title="">Rs. <?php echo number_format(round($data['avgSalary'])); ?></td>
			<td class="paid" title="">Rs. <?php echo number_format($data['paid']); ?></td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="view('<?php echo $data['date']; ?>')" title="View Salary Details">
					<img src="icon/eye" alt="View Icon" class="btnIcon" />
				</button>
				<button class="deleteBtn" onclick="deleteSalary('<?php echo $data['date']; ?>')" title="Delete Entry">
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
			echo "<small>Press Alt + N or Click on Create Salary Button to Add Salary</small>";
		}
	 ?>
	<footer>
		<script src="js/manageSalary.js"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>