<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT * FROM vouchers order by date desc, id desc';
	$execute = mysqli_query($con, $sql);
	$totalVouchers = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<title>Manage Company Expenses - Vouchers | Shree Engineering Works</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">Add Expenditure</button></td>
				<td align="center" width="40%"></td>
				<td align="right"  width="30%" class="p_a">
					<input type="text" placeholder="Search" autofocus id="searchInput" />
					<img src="icon/search" draggable="false" id="searchIcon" />
				</td>
			</tr>
		</table>
	</header>
	<?php if (!($totalVouchers == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Amount</th>
			<th>Receiver</th>
			<th>Description</th>
			<th style="text-align: center;">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalVouchers; $i++) { 
				$data = mysqli_fetch_assoc($execute);
				$date = date('d-M-y', strtotime($data['date']));
		?>
		<tr>
			<td title="Serial Number"><?php echo $i+1; ?></td>	
			<td class="date" title="Voucher's Date"><?php echo $date; ?></td>
			<td class="amount" title="Amount">Rs. <?php echo $data['amount']; ?></td>
			<td class="receiver" title="Receiver's Name"><?php echo $data['paidTo']; ?></td>	
			<td class="description" title="Description of Expenditure"><?php echo $data['description']; ?></td>	
			<td class="actions" style="text-align: center;">
				<button class="editBtn" onclick="edit(<?php echo $data['id']; ?>)" title="Edit Expenditure Details">
					<img src="img/icon/edit.png" alt="Edit Icon" class="btnIcon" />
				</button>
				<button class="deleteBtn" onclick="del(<?php echo $data['id']; ?>)" title="Delete Entry">
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
			echo "<small>Press Alt + N or Click on Add Expenditure Button to Add Entry</small>";
		}
	 ?>
	<footer>
		<script src="js/manageVouchers.js"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>