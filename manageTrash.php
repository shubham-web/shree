<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = 'SELECT * FROM companies order by name asc';
	$execute = mysqli_query($con, $sql);
	$totalCompanies = mysqli_num_rows($execute);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany.css" />
	<link rel="stylesheet" href="css/popup.css" />
	<title>Manage Trash Items</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%" cellspacing="0">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">Add New</button></td>
				<td align="center" width="40%"><button id="reportBtn">Company List</button></td>
				<td align="left"  width="30%" class="p_a"><input type="text" placeholder="Search" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<?php if (!($totalCompanies == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>GSTIN</th>
			<th>Contact</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalCompanies; $i++) { 
				$cData = mysqli_fetch_assoc($execute);
		?>
		<tr>
			<td class="cId" title="Serial Number"><?php echo $i+1; ?></td>	
			<td class="cName" title="Company name"><?php echo $cData['name']; ?></td>
			<td class="gstin" title="<?php echo $cData['name']; ?>'s GSTIN number"><?php echo $cData['gstin']; ?></td>
			<td class="cContact" title="Company Person 1 details">
				<span class="cpName"><?php echo $cData['contactPerson1']; ?></span>
				<span class="cMob" title="Mobile Number">(<?php echo $cData['contactNumber1']; ?>)</span>
			</td>	
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="viewCompany(<?php echo $cData['id']; ?>)" title="View Company Details">
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
				<button class="editBtn" onclick="editCompany(<?php echo $cData['id']; ?>)" title="Edit Company Details">
					<img src="img/icon/edit.png" alt="Edit Icon" class="btnIcon" />
				</button>
				<button class="deleteBtn" onclick="deleteCompany(<?php echo $cData['id']; ?>)" title="Delete Company Profile">
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
			echo "<small>Press Alt + N or Click on Add New Button to Add Company Profile</small>";
		}
	 ?>
	 <button id="view" hidden="">View Company Details</button>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table">
				<thead>
					<tr>
						<td colspan="2">
							<h1>Company Profile</h1>
						</td>
					</tr>
				</thead>
				<tbody id="companyDetails">
				</tbody>
			</table>
		</div>	
	</div>
	<footer>
		<script src="js/manageTrash"></script>
		<script src="js/frameContext"></script>
	</footer>
</body>
</html>