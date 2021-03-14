<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT * FROM `expenses` ORDER BY date DESC, id desc';
	$execute = mysqli_query($con, $sql);
	$totalExpenses = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany.css" />
	<link rel="stylesheet" href="css/popup.css" />
	<title>Manage Expenses</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">Add Exepenses</button></td>
				<td align="center" width="40%"><button id="reportBtn">Generate Purchase Report</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="Search" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<button id="view" hidden="">View Expenses Details</button>
	<?php if (!($totalExpenses == 0)) { ?>
<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Invoice Number</th>
			<th>Vendor</th>
			<th>Purchase Date</th>
			<th>Amount (With tax)</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalExpenses; $i++) { 
				$eData = mysqli_fetch_assoc($execute);
				$vId = $eData['vendorId'];
				$vName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `vendors` WHERE id=$vId"))['name'];
				$eDate = strtotime($eData['date']);
				$eDate = date("d-M-y", $eDate);
		?>
		<tr>
			<td title="serial number"><?php echo $i+1; ?></td>
			<td title="Invoice Number" class="invoiceNumber"><?php echo $eData['invoiceNumber']; ?></td>
			<td title="Vendor's Name" class="vName"><?php echo $vName; ?></td>	
			<td title="Purchase Date" class="date"><?php echo $eDate; ?></td>
			<td title="Purchase Amount with Tax">Rs. <?php echo $eData['total']; ?></td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="viewPayment(<?php echo $eData['id']; ?>)" title="View Purchase Details">
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
				<button class="editBtn" onclick="update(<?php echo $eData['id']; ?>)" title="Edit Purchase Details">
					<img src="img/icon/edit.png" alt="Edit Icon" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php
			} // For Loop
		 ?>
	</tbody>
	</table>
	<?php } // if of total companies
		else{
			echo "<h3>Nothing to Show</h3>";
			echo "<small>Press Alt + N or Click on Add Expenses Button</small>";
		}
	 ?>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table">
				<thead>
					<tr>
						<td colspan="2">
							<h1>Purchase Details</h1>
						</td>
					</tr>
				</thead>
				<tbody id="expensesDetails">
				</tbody>
			</table>
		</div>
	</div>
	<footer>
		<script src="js/manageExpenses"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>