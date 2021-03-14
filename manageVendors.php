<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT * FROM vendors order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalVendors = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany.css" />
	<link rel="stylesheet" href="css/popup.css" />
	<title>Manage Vendor's Profiles</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">Add New</button></td>
				<td align="center" width="40%"><button id="reportBtn">Vendors List</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="Search" id="searchInput" />
					<img src="icon/search" draggable="false" id="searchIcon" />
				</td>
			</tr>
		</table>
	</header>
	<button id="view" hidden="">View Vendor Details</button>
	<?php if (!($totalVendors == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>GSTIN</th>
			<th>Address</th>
			<th style="text-align: center;">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalVendors; $i++) { 
				$vData = mysqli_fetch_assoc($execute);
				// print_r($vData);
		?>
		<tr>
			<td class="vId" title="Serial Number"><?php echo $i + 1; ?></td>	
			<td class="vName" title="Vendor's name"><?php echo $vData['name']; ?></td>
			<td class="gstin" title="Vendor's GSTIN number"><?php echo $vData['gstin']; ?></td>
			<td class="vAddress" title="vendor's Address">
				<?php echo $vData['address']; ?>
			</td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="viewVendor(<?php echo $vData['id']; ?>)" title="View Vendor's Details">
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
				<button class="editBtn" onclick="editVendor(<?php echo $vData['id']; ?>)" title="Edit Vendor's Details">
					<img src="img/icon/edit.png" alt="Edit Icon" class="btnIcon" />
				</button>
				<button class="deleteBtn" onclick="deleteVendor(<?php echo $vData['id']; ?>)" title="Delete Vendor's Profile">
					<img src="img/icon/delete.png" alt="Delete Icon" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php } // For Loop ?>
	</tbody>
	</table>
	<?php } // if of total Vendors
		else{
			echo "<h3>Nothing to Show</h3>";
			echo "<small>Press Alt + N or Click on Add New Button to Add Vendor Profile</small>";
		}
	 ?>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table">
				<thead>
					<tr>
						<td colspan="2">
							<h1>Vendor's Profile</h1>
						</td>
					</tr>
				</thead>
				<tbody id="vendorDetails">
				</tbody>
			</table>
		</div>	
	</div>
	<footer>
		<script src="js/manageVendors.js"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>	