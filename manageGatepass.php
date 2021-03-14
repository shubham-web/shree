<?php 
	require 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = "SELECT * FROM `gatepasses` order by gatepassDate desc, id desc";
	$execute = mysqli_query($con, $sql);
	$pendingGatepasses = mysqli_num_rows($execute);
	$placeholder = "Search";
	if ($pendingGatepasses > 10) {
		$placeholder = 'Search Over '.$pendingGatepasses.' GatePasses';
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<link rel="stylesheet" href="css/popup" />
	<title>Manage Gatepasses</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">Add Gatepass</button></td>
				<td align="center" width="40%"><button id="reportBtn">Show Pending Gatepasses</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="<?php echo $placeholder; ?>" autofocus="" id="searchInput" title="Company Name / Gate-pass number" />
				<img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<?php if (!($pendingGatepasses == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>Company Name</th>
			<th>Gatepass Number</th>
			<th>Gatepass Date</th>
			<th style="text-align: center;">Status</th>
			<th style="text-align: center;">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $pendingGatepasses; $i++) {
				$data = mysqli_fetch_assoc($execute);
				$companyId = $data['companyId'];
				$selectCompany = "SELECT name FROM `companies` WHERE id = $companyId";
				$executeselectCompany = mysqli_query($con, $selectCompany);
				$cData = mysqli_fetch_assoc($executeselectCompany);
				$companyName = $cData['name'];
		?>
		<tr>
			<td title="Gatepass Id"><?php echo $i+1; ?></td>	
			<td class="companyName" title="Company name"><?php echo $companyName; ?></td>
			<td class="gatepassNumber" title="Gatepass Number"><?php echo $data['gatepassNumber']; ?></td>
			<td class="gatepassDate" title="Gatepass Date">
				<?php $gDate = strtotime($data['gatepassDate']);
					echo date('d-M-y', $gDate);
				 ?>
			</td>	
			<td class="status" style="color:<?php echo ($data['status'] === 'Delivered')? '#4cda65':'#f7ad00'; ?>;"
			title="Gatepass is <?php echo $data['status']; ?>">
				<?php echo $data['status']; ?>
			</td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="viewGatepass(<?php echo $data['id']; ?>)" title="View Gatepass Details">	
					<img src="img/icon/eye.png" alt="View Icon" class="btnIcon" />
				</button>
				<button class="editBtn" onclick="editGatepass(<?php echo $data['id']; ?>)" title="Edit Gatepass Details">
					<img src="img/icon/edit.png" alt="Edit Icon" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php } // For Loop ?>
	</tbody>
	</table>
	<?php } // if of total companies
		else{
			echo "<h3>No Gatepasses Found</h3>";
			echo "<small>Press Alt + N or Click on Add Gatepass Button to Add Gatepass</small>";
		}
	 ?>
	<button id="view" hidden="">View Gatepass Details</button>
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
				<tbody id="body">
				</tbody>
			</table>
		</div>
	</div>
	<footer>
		<script src="js/manageGatepass"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>