<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	isset($_GET['id']) or die("Error: Voucher Id not Provided");
	$voucherId = $_GET['id'];
	$sql = "SELECT * FROM `vouchers` WHERE id = $voucherId";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) == 0) die('Error: Voucher Entry Not Found with id '.$voucherId);
	$data = mysqli_fetch_assoc($result);
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<link rel="stylesheet" href="../css/vipForm" />
 	<link rel="stylesheet" href="../css/msgBox" />
 	<title>Modify Expenditure</title>
 </head>
 <body>
 	<img src="../icon/back" id="backIcon" />
	 <form id="formToAddCompany">
		<h1 id="heading">Modify Expenditure	</h1>
		<img src="../img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table width="80%">
				<tr>
					<td class="feildName">Date</td>
					<td><input type="date" autofocus id="date" value="<?php echo $data['date']; ?>" /></td>
				<tr>
					<td class="feildName">Amount</td>
					<td><input type="text" id="amount" value="<?php echo $data['amount'] ?>" placeholder="INR" autocomplete="off" maxlength="15" />
						<input type="hidden" id="id" value="<?php echo $data['id']; ?>" />
					</td>
				</tr>
				<tr>
					<td class="feildName">Receiver</td>
					<td><input type="text" id="receiver" value="<?php echo $data['paidTo'] ?>" placeholder="Paid to ..." /></td>
				</tr>
				<tr>
					<td class="feildName">Description</td>
					<td><textarea id="description" placeholder="Optional" cols="10" rows="3"><?php echo $data['description']; ?></textarea></td>
				</tr>
				<tr><td colspan="2" align="center"><button id="saveVoucher">Update</button></td></tr>
			</table>
		</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="../js/editVoucher.js"></script>
 	</footer>
 </body>
 </html>