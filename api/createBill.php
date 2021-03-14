<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die("Database Connection Failed");
	$hsnCode = $_POST['hsnCode'];
	$billNumber = $_POST['number'];
	$billDate = $_POST['date'];
	$companyId = $_POST['cId'];
	$gatepassNumber = $_POST['gNumber'];
	if ($gatepassNumber == '') {
		$gatepassNumber = null;
	}
	$vehicleNumber = $_POST['vehicleNumber'];
	$totalAmount = $_POST['totalAmount'];
	$cgst = $_POST['cgst'];
	$sgst = $_POST['sgst'];
	$igst = $_POST['igst'];
	$roundOff = $_POST['roundOff'];
	$netAmount = $_POST['netAmount'];
	$particularInfo = json_decode($_POST['particularInfo']);
	$addBill = "INSERT INTO `bills`(`billNumber`, `billDate`, `companyId`, `hsnCode`, `billAmount`, `sgst`, `cgst`, `igst`, `roundOff`, `billTotal`, `gatepassNumber`, `vehicleNumber`) VALUES ('$billNumber','$billDate', $companyId, '$hsnCode', '$totalAmount', '$sgst', '$cgst', '$igst', '$roundOff', '$netAmount', '$gatepassNumber', '$vehicleNumber')";
	$executeAddBill = mysqli_query($con, $addBill);
		$numofParticulars = count($particularInfo);
		if ($executeAddBill) {
			for ($i=0; $i < $numofParticulars; $i++) {
				$desc = $particularInfo[$i][0]; // 0 for Description
				$qty = $particularInfo[$i][1]; // 1 for quantity
				$price = $particularInfo[$i][2]; // 2 for price
				$total = $particularInfo[$i][3]; // 3 for total
				$addParticular = "INSERT INTO `particulars`(`billNumber`, `description`, `quantity`, `price`, `total`) VALUES ('$billNumber', '$desc', $qty, $price, $total)";
				$executeAddParticular = mysqli_query($con, $addParticular);
				if ($executeAddParticular) {
					$particularsAdded = true;
				}
				else{
					$particularsAdded = false;
					break;
				}
			} // For loop To insert Particulars
				
			if ($executeAddParticular) {
				if ($gatepassNumber !== null) {
					$delivered = mysqli_query($con, "UPDATE `gatepasses` SET `status`='Delivered' WHERE gatepassNumber = '$gatepassNumber' AND companyId = $companyId");
				}
				else{
					$delivered = true;
				}
				if ($delivered) {
					echo "Success";
				}
				else{
					echo "Error While Updating Gate pass Status";
				}
			}
			else{
				echo "Error While Adding Particulars";
			}
		}
		else{
			echo "Error While Adding Bill";
		}