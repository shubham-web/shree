<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	$paymentId = $_GET['paymentId'];
	$fetchPayment = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `payments` WHERE id = $paymentId"));
	$cId = $fetchPayment['companyId'];
	$cName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `companies` WHERE id=$cId"))['name'];
	$pDate = strtotime($fetchPayment['paymentDate']);
	$pDate = date("d-M-y", $pDate);
	$paymentInfo = json_decode($fetchPayment['paidBills'], true);
	echo "<tr>";
	echo "<td>Company Name</td>";
	echo "<td>".$cName."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Payment Date</td>";
	echo "<td>".$pDate."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Mode</td>";
	echo "<td>".$fetchPayment['modeOfPayment']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Amount</td>";
	echo "<td>Rs. ".$fetchPayment['paymentAmount']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2'><fieldset><legend>Associated Bills</legend><table><thead><th>Invoice Number</th><th>Amount</th></thead><tbody>";
		for ($i=0; $i < count($paymentInfo); $i++) { 
			echo "<tr>
				<td>".$paymentInfo[$i]['invoice']."</td>
				<td>Rs. ".$paymentInfo[$i]['amt']."</td>
			<tr>";
		}
	echo"</tbody></table></fieldset></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Description</td>";
	echo "<td>".$fetchPayment['description']."</td>";
	echo "</tr>";