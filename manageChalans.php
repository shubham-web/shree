<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = "SELECT number, date, companyId, gatepassNumber FROM `chalans` ORDER by date DESC";
	$execute = mysqli_query($con, $sql);
	$totalChalans = mysqli_num_rows($execute);
	$searchPlaceholder = 'Search';
	if ($totalChalans != 0) {
		if ($totalChalans > 10) {
			$searchPlaceholder = "Search over ".$totalChalans." chalans";
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany.css" />
	<link rel="stylesheet" href="css/popup.css" />
	<title>Manage Chalans</title>
</head>
<body>
	<header>
		<table  class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">New Chalan</button></td>
				<td align="center" width="40%"></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="<?php echo $searchPlaceholder ?>" autofocus="" id="searchInput" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<button id="view" hidden="">View Chalan Details</button>
	<?php if (!($totalChalans == 0)) { ?>
<table border="0" align="center">
	<thead>
		<tr>
			<th>Chalan Number</th>
			<th>Company Name</th>
			<th>GatePass Number</th>
			<th>Date</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalChalans; $i++) { 
				$cData = mysqli_fetch_assoc($execute);
				$cId = $cData['companyId'];
				$cName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `companies` WHERE id=$cId"))['name'];
				$cDate = strtotime($cData['date']);
				$cDate = date("d-M-y", $cDate);
		?>
		<tr>
			<td title="Chalan Number" class="chalanNumber"><?php echo $cData['number']; ?></td>
			<td title="Comapany Name" class="companyName"><?php echo $cName; ?></td>	
			<td title="Gatepass Number" class="gatepassNumber"><?php echo $cData['gatepassNumber']; ?></td>
			<td title="Chalan Date"><?php echo $cDate; ?></td>
			<td class="actions" style="text-align: center;">
				<button class="viewBtn" onclick="view('<?php echo $cData['number']; ?>')" title="View Chalan Details">
					<img src="icon/eye" alt="Edit Icon" class="btnIcon" />
				</button>
				<button class="editBtn" onclick="print('<?php echo $cData['number']; ?>')" title="Print Chalan Number <?php echo $cData['number']; ?>">
					<img src="icon/print" alt="View Icon" class="btnIcon" />
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
							<h1>Chalan Details</h1>
						</td>
					</tr>
				</thead>
				<tbody id="chalanBody">
				</tbody>
			</table>
		</div>
	</div>
	<footer>
		<script src="js/manageChalans"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>