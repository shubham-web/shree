<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$sql = "SELECT billNumber, companyId, gatepassNumber, billDate, billTotal, billStatus, remarks FROM `bills` ORDER by billDate DESC, id desc";
	$execute = mysqli_query($con, $sql);
	$totalBills = mysqli_num_rows($execute);
	$searchPlaceholder = 'Search';
	if ($totalBills != 0) {
		if ($totalBills > 10) {
			$searchPlaceholder = "Search over ".$totalBills." bills";
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/manageCompany" />
	<link rel="stylesheet" href="css/popup.css" />
	<title>Manage Bills</title>
</head>
<body>
	<header>
		<table class="noStyle" width="100%">
			<tr>
				<td align="left" width="30%"><button id="addNewBtn">New Bill</button></td>
				<td align="center" width="40%"><button id="manualBill">Manual Bill</button></td>
				<td align="right"  width="30%" class="p_a"><input type="text" placeholder="<?php echo $searchPlaceholder; ?>" autofocus="" id="searchInput" title="Invoice Number / Company Name / Gatepass Number / Date" /><img src="icon/search" draggable="false" id="searchIcon" /></td>
			</tr>
		</table>
	</header>
	<button id="view" hidden="">Edit Bill</button>
	<?php if (!($totalBills == 0)) { ?>
	<table border="0" align="center">
	<thead>
		<tr>
			<th>Invoice Number</th>
			<th>Company Name</th>
			<th>Gatepass Number</th>
			<th>Date</th>
			<th>Total Amount</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < $totalBills; $i++) {
				$data = mysqli_fetch_assoc($execute);
				$companyId = $data['companyId'];
				$companyName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `companies` WHERE id = $companyId"))['name'];
				// Date in yyyy-MM-dd Format
				$htmlDate = $data['billDate'];
				$htmlDate = strtotime($htmlDate);
				$htmlDate = date("Y-m-d", $htmlDate);
		?>
		<tr>
			<td title="Invoice Number" class="billNumber" style="font-weight: bold;"><?php echo $data['billNumber']; ?> <span class="billPaymentStts billPending"></span></td>	
			<td class="companyName" title="Company name"><?php echo $companyName; ?></td>
			<td class="gatepassNumber" title="Gatepass Number associated with bill">
				<?php echo ($data['gatepassNumber'] == '') ? '<small>Manual Bill</small>':$data['gatepassNumber']; ?></td>
			<td title="Bill Date" class="billDate">
				<?php $gDate = strtotime($data['billDate']);
					echo date('d-M-y', $gDate);
				 ?>
			</td>	
			<td class="totalAmount" title="Total Bill Amount (Including Tax)">Rs. <?php echo $data['billTotal']; ?></td>
			<td class="actions" style="text-align: center;">
				<button class="editBtn" onclick="edit('<?php echo $data['billNumber'];  ?>', '<?php echo $htmlDate; ?>')" title="Edit Bill Details">
					<img src="icon/edit" alt="Edit Icon" class="btnIcon" />
				</button>
				<button class="viewBtn" onclick="print('<?php echo $data['billNumber']; ?>')" title="Print Bill Number <?php echo $data['billNumber']; ?>">
					<img src="icon/print" alt="View Icon" class="btnIcon" />
				</button>
				<button onclick="changeStatus('<?php echo $data['billNumber'];  ?>', '<?php echo $data['remarks']; ?>', '<?php echo $data['billStatus']; ?>')" style="background-color:<?php echo ($data['billStatus'] === '1') ? '#58e870':'orangered'; ?>;" title="Bill Status <?php echo $data['remarks']; ?>">
					<img src="icon/<?php echo ($data['billStatus'] === '1')? 'checkedCircle' : 'warning'; ?>" class="btnIcon" />
				</button>
			</td>
		</tr>
		<?php } // For Loop ?>
	</tbody>
	</table>
	<?php } // if of total bills
		else
			echo "<h3>No Bills Generated...</h3>
				 <small>Press Alt + N or Click on New Bill Button to Generate new Bill</small>";
	 ?>
	 <div id="popupBox">
		<div id="content">
		<span id="dismiss">&times;</span>
			<table cellspacing="0" cellpadding="10" id="table"></table>
		</div>
	</div>
	<footer>
		<script src="js/manageBills"></script>
		<script src="js/frameContext.js"></script>
	</footer>
</body>
</html>