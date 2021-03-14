<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	if (!isset($_GET['billNumber'])) die('Invalid Request');
	$queryBillNumber = $_GET['billNumber'];
	$billSQL = "SELECT bills.billNumber, bills.billDate, bills.companyId, bills.hsnCode, bills.billAmount, bills.sgst, bills.cgst, bills.igst, bills.roundOff, bills.billTotal, bills.gatepassNumber, bills.vehicleNumber, particulars.id AS particularId, particulars.description AS pDescription, particulars.quantity AS pQuantity, particulars.price AS pPrice, particulars.total AS pTotal FROM `bills` INNER JOIN particulars on bills.billNumber=particulars.billNumber WHERE bills.billNumber = '$queryBillNumber'  AND particulars.quantity != 0 AND particulars.price != 0 AND particulars.price != 0";
	$billDetails = mysqli_query($con, $billSQL);
	$billData = mysqli_fetch_assoc($billDetails);
	$num = mysqli_num_rows($billDetails);
	if ($num == 0) {
		die('Bill Not Found');
	}
	$cId = $billData['companyId'];

	$companySQL = "SELECT * FROM `companies` WHERE id = $cId";

	$companyDetails = mysqli_query($con, $companySQL);
	$companyData = mysqli_fetch_assoc($companyDetails);

	$billNumber = $billData['billNumber'];
	$hsn = $billData['hsnCode'];
	$companyName = $companyData['name'];
	$companyGSTIN = $companyData['gstin'];
	$companyAdd = $companyData['address'];
	$vehicleNumber = $billData['vehicleNumber'];
	$billDate = $billData['billDate'];
	$billDate = strtotime($billDate);
	$billDate = date("d-M-y", $billDate);
	$gatepassNumber = $billData['gatepassNumber'];
	$gatepassDate = mysqli_fetch_assoc(mysqli_query($con, "SELECT gatepassDate FROM `gatepasses` WHERE gatepassNumber = '$gatepassNumber'"))['gatepassDate'];
	$gatepassDate = strtotime($gatepassDate);
	$gatepassDate = date("d-M-y", $gatepassDate);

	if ($gatepassNumber == '') {
		$gatepassDate = '';
	}

	
	$billAmount = $billData['billAmount'];
	$sgst = $billData['sgst'];
	$cgst = $billData['cgst'];
	$igst = $billData['igst'];
	if ($billData['roundOff'] == 0) {
		$roundOff  = "-";
	}
	else{
		$roundOff = $billData['roundOff'];
	}
	$billTotal = $billData['billTotal'];

   $number = $billTotal;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'ONE', '2' => 'TWO',
    '3' => 'THREE', '4' => 'FOUR', '5' => 'FIVE', '6' => 'SIX',
    '7' => 'SEVEN', '8' => 'EIGHT', '9' => 'NINE',
    '10' => 'TEN', '11' => 'ELEVEN', '12' => 'TWELVE',
    '13' => 'THIRTEEN', '14' => 'FOURTEEN',
    '15' => 'FIFTEEN', '16' => 'SIXTEEN', '17' => 'SEVENTEEN',
    '18' => 'EIGHTEEN', '19' =>'NINETEEN', '20' => 'TWENTY',
    '30' => 'THIRTY', '40' => 'FORTY', '50' => 'FIFTY',
    '60' => 'SIXTY', '70' => 'SEVENTY',
    '80' => 'EIGHTY', '90' => 'NINETY');
   $digits = array('', 'HUNDRED', 'THOUSAND', 'LAKH', 'CRORE');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' AND ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
   $inWords = $result . " ONLY";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $billNumber; ?></title>
	<style>
		body{
			margin: 0;
			padding: 0;
			padding-left: 25px;
		}
		table{
			border-collapse: collapse;
			width: 100%;
		}
		td{
			padding: 6px;
		}
		.particularDesc{
			text-align: left;
		}
		.particularDesc, .particularQty, .particularRate, .particularAmount{
			display: inline-block;
			width: 100%;
			margin: 0;
			height: 50px;
		}
		#seal{
			height: 110px;
		}
		#rollDetails{
			height: 200px;
		}
		#rorollDetails td{
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
	</style>
</head>
<body>
	<table border="1" align="center">
		<tr>
			<td colspan="4" align="right" style="font-size: 12px;">Original / Duplicate / Triplicate</td>
		</tr>

		<tr>
			<td colspan="4"><h4 align="center">TAX INVOICE</h4></td>
		</tr>

		<tr>
			<td width="30%" align="center"><img src="../img/TransparentLogo.png" width="200"></td>
			<td colspan="3" align="center">
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
			<td colspan="2">
				GSTIN NO. <?php echo $GLOBALS['gstin']; ?>
			</td>
			<td>
				HSN Code
			</td>
			<td><?php echo $hsn; ?></td>
		</tr>

		<tr>
			<td colspan="2" width="60%">Detail for reciever (billed to)</td>
			<td width="20%">INVOICE No.</td>
			<td width="20%"><span id="billNumber"><?php echo $billNumber; ?></span></td>
		</tr>

		<tr>
			<td colspan="2" width="60%">M/s :- <span id="companyName"><?php echo $companyName; ?></span></td>
			<td width="20%">Dated </td>
			<td width="20%"><?php echo $billDate; ?></td>
		</tr>

		<tr>
			<td colspan="2" rowspan="2" width="60%">
				FACTORY :- <?php echo $companyAdd; ?></td>
			<td width="20%">Your R.G.P. NO </td>
			<td width="20%"><?php echo $gatepassNumber; ?></td>
		</tr>
		<tr>
			<td width="20%">Dated </td>
			<td width="20%"><?php echo $gatepassDate; ?></td>
		</tr>

		<tr>
			<td colspan="2" width="60%">GSTIN:- <?php echo $companyGSTIN; ?></td>
			<td width="20%">Vehicle No</td>
			<td width="20%"><?php echo $vehicleNumber; ?></td>
		</tr>


		<tr>
			<td width="45%" align="center">
				Description of goods
			</td>
			<td width="10%" align="center">
				QUANTITY
			</td>
			<td width="25%" align="center">
				RATE / per
			</td>
			<td width="30%" align="center">
				AMOUNT
			</td>
		</tr>
		<tr id="rollDetails">
			<td width="45%" align="center" valign="top">
			<?php 
				$pDetails = mysqli_query($con, $billSQL);
				for ($i=0; $i < $num; $i++) { 
					$pData = mysqli_fetch_assoc($pDetails);
					echo "<p class=\"particularDesc\" id=\"particularDesc1\">";
					echo "(".($i+1).") ";
				  	echo $pData['pDescription']."</p>";
				}
			 ?>
			</td>
			<td width="10%" align="center"  valign="top">
				<?php 
				$pDetails = mysqli_query($con, $billSQL);
					for ($i=0; $i < $num; $i++) {
						$pData = mysqli_fetch_assoc($pDetails);
						echo "<p class=\"particularQty\">";
						if ($pData['pTotal'] < 0) { echo "-"; } // For Discount
						else{
						  	$desc = $pData['pDescription'];
							$qty = $pData['pQuantity'];
							$pos = stripos($desc, "roll");
							$cwPos = stripos($desc, 'carbon'); // for Carbon Wonder Particulars
							// ---Unit Based On Description------
							if ($pos === false) {
								if ($cwPos === false) {
									echo round($qty)." Num";
								}
								else{
									echo $qty." MT";
								}
							}
							else{ echo ($qty > 1) ? round($qty)." Rolls": round($qty)." Roll"; }
							// ---------Unit----------------
						}
						echo "</p>";
					}
				 ?>
			</td>
			<td width="25%" align="center"  valign="top">
				<?php 
					$pDetails = mysqli_query($con, $billSQL);
					for ($i=0; $i < $num; $i++) { 
						$pData = mysqli_fetch_assoc($pDetails);
						echo "<p class=\"particularRate\">";
						if ($pData['pTotal'] < 0) {
							echo "-";
						}
						else{
						  	echo $pData['pPrice'];
						}
					  	echo "</p>";
					}
				 ?>
			</td>
			<td width="30%" align="center"  valign="top">
				<?php 
					$pDetails = mysqli_query($con, $billSQL);
					for ($i=0; $i < $num; $i++) { 
						$pData = mysqli_fetch_assoc($pDetails);
						echo "<p class=\"particularAmount\">";
					  	echo $pData['pTotal']."</p>";
					}
				 ?>
			</td>
		</tr>
		<?php 
			$fetchNote = "SELECT description FROM `particulars` WHERE billNumber = '$billNumber' AND quantity = 0 AND price = 0";
			$exeNote = mysqli_query($con, $fetchNote);
			$noteNum = mysqli_num_rows($exeNote);
			if ($noteNum != 0) {
				$note = mysqli_fetch_assoc($exeNote)['description'];
		?>
		<tr>
			<td colspan="4">
				<b>Note:- </b><?php echo $note; ?>
			</td>
		</tr>
		<?php } // if $noteNum != 0	?>
		<tr>
			<td colspan="2" rowspan="3" width="60%">
				Banking Details :- <?php echo strtoupper($GLOBALS['title']); ?> <br>
				<?php echo $GLOBALS['bankName']; ?> <br>
				ACCOUNT NO.:- <?php echo $GLOBALS['accountNumber']; ?> <br>
				IFSC CODE:- <?php echo $GLOBALS['ifscCode']; ?> <br>
			</td>
			<td width="20%">Total Taxable Amount</td>
			<td width="20%" align="right"><?php echo $billAmount; ?></td>
		</tr>

<?php 
	if ($igst == 0) {
?>
		<tr>
			<td width="20%">ADD: CGST @ <?php echo $GLOBALS['CGST_RATE']; ?>%</td>
			<td align="right"><?php echo $cgst; ?></td>
		</tr>
		<tr>
			<td width="20%">ADD: SGST @ <?php echo $GLOBALS['SGST_RATE']; ?>%</td>
			<td align="right"><?php echo $sgst; ?></td>
		</tr>
<?php }
else{
?>		<tr>
			<td width="20%" rowspan="2">ADD: IGST @ <?php echo $GLOBALS['IGST_RATE']; ?>%</td>
			<td rowspan="2" align="right"><?php echo $igst; ?></td>
		</tr>
		<tr></tr>
<?php } ?>

		<tr>
			<td colspan="2" rowspan="2" width="60%">
				<?php echo $inWords; ?>
			</td>
			<td width="20%">Round Off ( + / - )</td>
			<td width="20%" align="right"><span id="billNumber"><?php echo $roundOff; ?></span></td>
		</tr>

		<tr>
			<td>Net Invoice Amount</td>
			<td align="right"><?php echo $billTotal; ?></td>
		</tr>

		<tr id="seal">
			<td colspan="4" valign="bottom" align="right" style="font-size: 1.2em;">
				<?php echo $GLOBALS['title']; ?>
			</td>
		</tr>
	</table>
	<script>
		window.addEventListener('afterprint', function () {
			document.body.innerHTML = 'Bill Number <b><?php echo $billNumber; ?></b> Printed'
			setTimeout(function () {
				window.close()
			}, 1000)
		})
		window.print()	
	</script>
</body>
</html>