<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect() or die("Database Connection Failed");
	$Id = $_GET['Id'];
	$fetchCompany = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `companies` WHERE id = $Id"));
	$name = $fetchCompany['name'];
	$address = $fetchCompany['address'];
	$gstin = $fetchCompany['gstin'];
	$cp1 = $fetchCompany['contactPerson1']." ( ".$fetchCompany['contactNumber1']." )";
	$cp2 = '';
	if ($fetchCompany['contactPerson2'] !== '') {
		$cp2 .= $fetchCompany['contactPerson2'];
		if ($fetchCompany['contactNumber2'] !== '') {
			$cp2 .= " ( ".$fetchCompany['contactNumber2']." )";
		}
	}

	echo "<tr>";
	echo "<td>Company Name</td>";
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
	echo "<td>Contact Person I</td>";
	echo "<td>".$cp1."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Contact Person II</td>";
	echo "<td>".$cp2."</td>";
	echo "</tr>";