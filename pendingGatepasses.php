<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = "SELECT * FROM `gatepasses` WHERE status = 'Pending'";
	$execute = mysqli_query($con, $sql);
	$pendingGatepasses = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany.css" />
	<link rel="stylesheet" href="css/popup.css" />
	<title>View Pending Gatepasses</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="10%"><img src="icon/back" alt="" id="backIcon"></td>
				<td align="left" width="60%"><h1>Pending Gatepasses</h1></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="Search" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<button id="view" hidden="">View Gatepass Details</button>
	<?php if (!($pendingGatepasses == 0)) { ?>
<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Company Name</th>
			<th>Gatepass Number</th>
			<th>Gatepass Date</th>
			<th style="text-align: center;">View Details</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $pendingGatepasses; $i++) { 
				$gData = mysqli_fetch_assoc($execute);
				$cId = $gData['companyId'];
				$cName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `companies` WHERE id=$cId"))['name'];
				$gDate = strtotime($gData['gatepassDate']);
				$gDate = date("d-M-y", $gDate);
				$gatepassNumber = $gData['gatepassNumber'];
		?>
		<tr>
			<td title="Serial Number"><?php echo $i+1; ?></td>
			<td title="Company Name" class="cName"><?php echo $cName; ?></td>	
			<td title="Gatepass Number" class="gatepassNumber"><?php echo $gatepassNumber; ?></td>
			<td title="Gatepass Date"><?php echo $gDate; ?></td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="viewRolls('<?php echo $gatepassNumber; ?>',<?php echo $cId; ?>)" title="View Rolls Details">
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php
			} // For Loop
		 ?>
	</tbody>
	</table>
	<?php } // if of total pending gatepasses
		else{
			echo "<h3>No Pending Gatepasses</h3>";
			echo "<small>All Are Delivered</small>";
		}
	 ?>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table">
				<thead>
					<tr>
						<td colspan="2">
							<h1>Gatepass Details</h1>
						</td>
					</tr>
				</thead>
				<tbody id="rollsInfo">
				</tbody>
			</table>
		</div>
	</div>
	<footer>
		<script src="js/pendingGatepasses"></script>
	</footer>
</body>
</html>