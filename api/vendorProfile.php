<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	$Id = $_GET['Id'];
	$fetchVendor = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `vendors` WHERE id = $Id"));
	$name = $fetchVendor['name'];
	$address = $fetchVendor['address'];
	$gstin = $fetchVendor['gstin'];
	$description = $fetchVendor['description'];

	echo "<tr>";
	echo "<td>Vendor's Name</td>";
	echo "<td>".$name."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Address</td>";
	echo "<td>".$address."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>GSTIN</td>";
	echo "<td>".$gstin."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Description</td>";
	echo "<td>".$description."</td>";
	echo "</tr>";