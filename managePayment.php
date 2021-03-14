<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT * FROM payments ORDER BY paymentDate desc';
	$execute = mysqli_query($con, $sql);
	$totalCompanies = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<link rel="stylesheet" href="css/popup" />
	<title>Manage Payments</title>
</head>
<body>
	<header>
		<table class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">Add Payment</button></td>
				<td align="center" width="40%"><button id="reportBtn">Monthly Payment Report</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="Search" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<button id="view" hidden="">View Payment Details</button>
	<?php if (!($totalCompanies == 0)) { ?>
<table border="0" align="center">
	<thead>
		<tr>
			<th>Company Name</th>
			<th>Payment Date</th>
			<th>Mode</th>
			<th>Amount</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalCompanies; $i++) { 
				$pData = mysqli_fetch_assoc($execute);
				$cId = $pData['companyId'];
				$cName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `companies` WHERE id=$cId"))['name'];
				$pDate = strtotime($pData['paymentDate']);
				$pDate = date("d-M-y", $pDate);
		?>
		<tr id="row_<?php echo $pData['id']; ?>">
			<td title="Company Name" class="cName"><?php echo $cName; ?></td>	
			<td title="Payment Date" class="paymentDate"><?php echo $pDate; ?></td>
			<td title="Mode Of Payment" class="mode"><?php echo $pData['modeOfPayment']; ?></td>
			<td title="Payment Amount">Rs. <?php echo $pData['paymentAmount']; ?></td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="viewPayment(<?php echo $pData['id']; ?>)" title="View Payment Details">
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
				<button class="deleteBtn" onclick="deletePayment(<?php echo $pData['id']; ?>)" title="Delete Payment Entry | It will Also Affect Associated Bills">
					<img src="img/icon/delete.png" alt="Delete Icon" class="btnIcon" />
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
			echo "<small>Press Alt + N or Click on Add Payment Button</small>";
		}
	 ?>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table">
				<thead>
					<tr>
						<td colspan="2">
							<h1>Payment Details</h1>
						</td>
					</tr>
				</thead>
				<tbody id="paymentDetails"></tbody>
			</table>
		</div>
	</div>

	<span class="" id="ajaxMessages"></span>
	<footer>
		<script src="js/managePayment"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>