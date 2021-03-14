<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	isset($_GET['Id']) or die("Invalid Request");
	$id = $_GET['Id'];
	$fetchExpenses = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `expenses` WHERE id = $id"));
	$vId = $fetchExpenses['vendorId'];
	$vName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM `vendors` WHERE id=$vId"))['name'];
	$eDate = strtotime($fetchExpenses['date']);
	$eDate = date("d-M-y", $eDate);
	echo "<tr>";
	echo "<td>Invoice Number</td>";
	echo "<td>".$fetchExpenses['invoiceNumber']."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Vendor's Name</td>";
	echo "<td>".$vName."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Purchase Date</td>";
	echo "<td>".$eDate."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Amount</td>";
	echo "<td>Rs. ".$fetchExpenses['amount']."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Tax</td>";
	echo "<td> ". ($fetchExpenses['amount'] * $fetchExpenses['taxPercentage']) / 100 ." (".$fetchExpenses['taxPercentage']."%)</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Total Amount</td>";
	echo "<td>Rs. ".$fetchExpenses['total']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Description</td>";
	echo "<td>".$fetchExpenses['description']."</td>";
	echo "</tr>";