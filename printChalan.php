<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	if (!isset($_GET['chalanNumber']))	die("Invalid Request");
	$chalanNumber = $_GET['chalanNumber'];
	$fetchChalan = "SELECT * FROM `chalans` WHERE chalans.number = $chalanNumber";
	$exeChalan = mysqli_query($con, $fetchChalan);
	$num = mysqli_num_rows($exeChalan);
	if ($num == 0) die("Chalan Not Found");
	$chalanData = mysqli_fetch_assoc($exeChalan);

	// Company Details
	$cId = $chalanData['companyId'];
	$fetchCompany = "SELECT name, address FROM `companies` WHERE id = $cId";
	$exeCompany = mysqli_query($con, $fetchCompany);
	$cData = mysqli_fetch_assoc($exeCompany);
	$companyName = $cData['name'];
	$companyAdd = $cData['address'];
	$rollsInfo = json_decode($chalanData['rollsInfo']);

	// Chalan Details from chalans table
	$chalanDate = $chalanData['date'];
	$chalanDate = strtotime($chalanDate);
	$chalanDate = date("d-M-Y", $chalanDate);
	$vehicleNumber = $chalanData['vehicleNumber'];

	//Gatepass data
	$gatepassNumber = $chalanData['gatepassNumber'];
	$fetchGatepass = "SELECT gatepassDate FROM `gatepasses` WHERE gatepassNumber = '$gatepassNumber'";
	$exeGatepass = mysqli_query($con, $fetchGatepass);
	$gatepassData = mysqli_fetch_assoc($exeGatepass);
	$gatepassDate = $gatepassData['gatepassDate'];
	$gatepassDate = strtotime($gatepassDate);
	$gatepassDate = date("d-M-Y", $gatepassDate);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ChalanNo_<?php echo $chalanNumber; ?></title>
	<style>
		body{
			margin: 0;
			padding: 0;
		}
		table{
			border-collapse: collapse;
			width: 100%;
		}
		td{
			padding: 6px;
		}		
		#seal{
			height: 110px;
		}
		#rollDetails{
			height: 100px;
		}
		#rollDetails td{
			vertical-align: top;
		}
		*{
			font-family: Arial, sans-serif;
			font-size: 14px;
		}
		h1,h2,h3,h4,h5,h6{
			margin: 0;
		}
		h1{
			font-size: 1.5em;
		}
		h2{
			font-size: 1.2em;
		}
		h3{
			font-size: 1.1em;
		}
		h4{
			font-size: 1em;
		}
		h3{
			font-size: 0.9em;
		}
		address{
			font-size: 12px;	
		}
		p{
			margin: 5px;
		}
	</style>
</head>
<body>
	<table border="1" align="center" class="noStyle">
		<tr>
			<td colspan="5"><h2 align="center">CHALAN</h2></td>
		</tr>

		<tr>
			<td colspan="5" align="center">
				<small>"Shree"</small>
				<h1><?php echo $GLOBALS['title']; ?></h1>
				<span><?php echo $GLOBALS['subTitle'];; ?></span>
				<address>Work: 
					<?php echo $GLOBALS['workAddress']; ?>
				</address>
				<address>Office: 
					<?php echo $GLOBALS['officeAddress'];; ?>
				</address>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="60%">Detail for reciever</td>
			<td width="20%" colspan="2">CHALAN No.</td>
			<td width="20%"><?php echo $chalanNumber; ?></td>
		</$cIdr>

		<tr>
			<td colspan="2" width="60%">M/s :- <span id="companyName"><?php echo $companyName; ?></span></td>
			<td width="20%" colspan="2">Dated </td>
			<td width="20%"><?php echo $chalanDate; ?></td>
		</tr>

		<tr>
			<td colspan="2" rowspan="3" width="60%" valign="top">
				Factory :- <?php echo $companyAdd; ?> </td>
			<td width="20%" colspan="2">Your R.G.P. NO </td>
			<td width="20%"><?php echo $gatepassNumber; ?></td>
		</tr>
		<tr>
			<td width="20%" colspan="2">Dated</td>
			<td width="20%"><?php echo $gatepassDate; ?></td>
		</tr>

		<tr>
			<td width="20%" colspan="2">Vehicle No</td>
			<td width="20%"><?php echo $vehicleNumber; ?></td>
		</tr>

		<tr>
			<td align="center" colspan="3">
				Description of goods
			</td>
			<td align="center" colspan="2">
				Quantity
			</td>
		</tr>
		<tr id="rollDetails">
			<td align="left" valign="top" colspan="3">
				<?php 
					for ($i=0; $i < count($rollsInfo); $i++) { 
					$desc = $rollsInfo[$i][1];
					echo "<p>";
					echo "(".($i+1).") ";
					echo $desc;
					echo "</p>";
				} ?>
			</td>
			<td align="center"  valign="top" colspan="2">
					<?php 
					for ($i=0; $i < count($rollsInfo); $i++) { 
					$desc = $rollsInfo[$i][1];
					$qty = $rollsInfo[$i][0];
					$pos = stripos($desc, "roll");
					echo "<p>";
					echo $qty;
					if ($pos === false) {echo " Num";}
					else{ echo ($qty > 1) ? " Rolls": " Roll"; }
					echo "</p>";
				} ?>
				</p>
			</td>
		</tr>
		<tr id="seal">
			<td colspan="5" valign="bottom" align="right" style="font-size: 1.2em;">
				<?php echo $GLOBALS['title']; ?>
			</td>
		</tr>
	</table>
	<script>
		window.addEventListener('afterprint', function () {
			history.pushState(null, null, 'chalan-no-<?php echo $chalanNumber ?>-printed')
			document.body.innerHTML = 'Chalan Number <b><?php echo $chalanNumber; ?></b> Printed'
			setTimeout(function () {
				window.close()
			}, 1000)
		})
		window.print()
		history.pushState(null, null, '../print-chalan')
	</script>
</body>
</html>