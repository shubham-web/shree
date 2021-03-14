<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	$Id = $_GET['Id'];
	$fetchEmployee = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `employees` WHERE id = $Id"));
	$name = $fetchEmployee['name'];
	$edu = $fetchEmployee['qualification'];
	$mobile = $fetchEmployee['mobileNumber'];
	$aadhar = $fetchEmployee['aadhar'];
	$joiningDate = date('d-M-Y',strtotime($fetchEmployee['joiningDate']));
	$salary = $fetchEmployee['salary'];
	echo "<tr>";
	echo "<td>Name</td>";
	echo "<td>".$name."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Qualification</td>";
	echo "<td>".$edu."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Contact</td>";
	echo "<td>".$mobile."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Aadhar Number</td>";
	echo "<td>".$aadhar."</td>";
	echo "</tr>";
	echo "<tr>";

	echo "<td>Joining Date</td>";
	echo "<td>".$joiningDate."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>Salary</td>";
	echo "<td>".$salary."</td>";
	echo "</tr>";