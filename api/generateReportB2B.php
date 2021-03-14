<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	if (!isset($_POST['year']) && !isset($_POST['month'])) {
		http_response_code(400);
		die("Invalid Request");
	}
	else{
		$year = $_POST['year'];
		$month = $_POST['month'];
		$billSQL = "SELECT * FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year AND billStatus = 1";
		$billResult = mysqli_query($con, $billSQL);
		$numOfInvoices = mysqli_num_rows($billResult);
		$numOfRecipients = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(DISTINCT companyId) as recipients FROM `bills` WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year AND billStatus = 1"))['recipients'];
		$totalInvoieValue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(billTotal) as sumWithTax FROM `bills`WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year AND billStatus = 1"))['sumWithTax'];
		$totalTaxableValue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(billAmount) as sumWithoutTax FROM `bills`WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year  AND billStatus = 1"))['sumWithoutTax'];
		$tinArray = array('35' => 'Andaman and Nicobar Islands',
							'37' => 'Andhra Pradesh',
							'12' => 'Arunachal Pradesh',
							'18' => 'Assam',
							'10' => 'Bihar',
							'04' => 'Chandigarh',
							'22' => 'Chattisgarh',
							'26' => 'Dadra and Nagar Haveli',
							'25' => 'Daman and Diu',
							'07' => 'Delhi',
							'30' => 'Goa',
							'24' => 'Gujarat',
							'06' => 'Haryana',
							'02' => 'Himachal Pradesh',
							'01' => 'Jammu and Kashmir',
							'20' => 'Jharkhand',
							'29' => 'Karnataka',
							'32' => 'Kerala',
							'31' => 'Lakshadweep Islands',
							'23' => 'Madhya Pradesh',
							'27' => 'Maharashtra',
							'14' => 'Manipur',
							'17' => 'Meghalaya',
							'15' => 'Mizoram',
							'13' => 'Nagaland',
							'21' => 'Odisha',
							'34' => 'Pondicherry',
							'03' => 'Punjab',
							'08' => 'Rajasthan',
							'11' => 'Sikkim',
							'33' => 'Tamil Nadu',
							'36' => 'Telangana',
							'16' => 'Tripura',
							'09' => 'Uttar Pradesh',
							'05' => 'Uttarakhand',
							'19' => 'West Bengal');
	}
?>
	<table id="gstr" border="1" cellpadding="5">
		<tr>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;">No. of Recipients</td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;">No. of Invoices</td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;"></td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;">Total Invoice Value</td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;"></td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;"></td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;"></td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;"></td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;"></td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;">Total Taxable Value</td>
			<td style="background-color: #6064ea;color: #fff; text-align: center; font-weight: bold;">Total Cess	</td>
		</tr>
		<tr>
			<td style="text-align: center;"><?php echo $numOfRecipients; ?></td>
			<td style="text-align: center;"><?php echo $numOfInvoices; ?></td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"><?php echo $totalInvoieValue; ?>.00</td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"><?php echo $totalTaxableValue; ?>.00</td>
			<td style="text-align: center;">0</td>
		</tr>
		<tr>
			<td style="background-color: #ffc; ">GSTIN/UIN of Recipient</td>
			<td style="background-color: #ffc; ">Invoice Number</td>
			<td style="background-color: #ffc; ">Invoice Date</td>
			<td style="background-color: #ffc; ">Invoice Value</td>
			<td style="background-color: #ffc; ">Place of Supply</td>
			<td style="background-color: #ffc; ">Reverse Charge</td>
			<td style="background-color: #ffc; ">Invoice Type</td>
			<td style="background-color: #ffc; ">E-Commerce GSTIN</td>
			<td style="background-color: #ffc; ">Rate</td>
			<td style="background-color: #ffc; ">Taxable Value</td>
			<td style="background-color: #ffc; ">Cess Amount</td>
		</tr>
		<?php 
			for ($i=0; $i < $numOfInvoices; $i++) { 
			$data = mysqli_fetch_assoc($billResult);
			$invoiceNumber = $data['billNumber'];
			$invoiceDate = $data['billDate'];
			$invoiceDate = strtotime($invoiceDate);
			$invoiceDate = date("d-M-y", $invoiceDate);
			$companyId = $data['companyId'];
			$gstin = mysqli_fetch_assoc(mysqli_query($con, "SELECT gstin FROM `companies` WHERE id = $companyId"))['gstin'];
			$tinNumber = substr($gstin, 0,2);
			$invoiceValue = $data['billTotal'];
			$taxableValue = $data['billAmount'];
		?>
		<tr>
			<td><?php echo $gstin; ?></td>
			<td><?php echo $invoiceNumber; ?></td>
			<td><?php echo $invoiceDate; ?></td>
			<td style="text-align: right;"><?php echo $invoiceValue; ?>.00</td>
			<td><?php echo $tinNumber."-".$tinArray[$tinNumber]; ?></td>
			<td style="text-align: center;">N</td>
			<td>Regular</td>
			<td></td>
			<td style="text-align: right;">18%</td>
			<td style="text-align: right;"><?php echo $taxableValue; ?>.00</td>
			<td style="text-align: right;">0</td>
		</tr>
		<?php } // For Loop	?>
	</table>