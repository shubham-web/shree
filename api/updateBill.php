<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$hsnCode = $_POST['hsnCode'];
	$billNumber = $_POST['number'];
	$billDate = $_POST['date'];
	$companyId = $_POST['cId'];
	$oldCID = $_POST['oldCID'];
	$oldGPN = $_POST['oldGPN'];

	$gatepassNumber = $_POST['gNumber'];
	$vehicleNumber = $_POST['vehicleNumber'];
	$totalAmount = $_POST['totalAmount'];
	$cgst = $_POST['cgst'];
	$sgst = $_POST['sgst'];
	$igst = $_POST['igst'];
	$roundOff = $_POST['roundOff'];
	$netAmount = $_POST['netAmount'];
	$particularInfo = json_decode($_POST['particularInfo']);
	$updateBill = "UPDATE `bills` SET `billDate`= '$billDate',`hsnCode`= '$hsnCode',`companyId`=$companyId,`gatepassNumber`='$gatepassNumber',`vehicleNumber`='$vehicleNumber',`billAmount`=$totalAmount,`sgst`='$sgst',`cgst`='$cgst',`igst`='$igst',`billTotal`='$netAmount',`roundOff`='$roundOff',`billStatus`= 1,`remarks`= null WHERE billNumber = '$billNumber'";
	$executeUpdateBill = mysqli_query($con, $updateBill);
	$numofParticulars = count($particularInfo);
	if ($executeUpdateBill) {
		$deleteOldParticularsSQL = "DELETE FROM `particulars` WHERE billNumber = '$billNumber'";
		$deleteOldParticulars = mysqli_query($con, $deleteOldParticularsSQL);
		if ($deleteOldParticulars) {
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
			} // For Loop
			if ($particularsAdded) {
				$delivered = mysqli_query($con, "UPDATE `gatepasses` SET `status`='Delivered' WHERE gatepassNumber = '$gatepassNumber' AND companyId = $companyId");
				if ($delivered) {
					$oldPending = "UPDATE `gatepasses` SET `status`='Pending' WHERE gatepassNumber = '$oldGPN' AND companyId = $oldCID";
					$exeOldPending = mysqli_query($con, $oldPending);
					if ($exeOldPending) {
						echo "Success";
					}
					else{
						echo "Error while Updating Previous Gatepass Status to Pending";
					}
				}
				else{
					echo "Error while Updating Gate Pass to Delivered";
				}
			}
			else{
				echo "Error while Adding Particulars Info";
			}
		} // If delete Old Particular 
		else{
			echo "Error while Deleting Old Particulars";
		}
	} // 
	else{
		echo "Error While Updating Bill";
	}