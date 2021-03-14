<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();
	$cId = $_GET['cId'];
	$status = $_GET['status'];
	if ($status == 'Both') {
		$sql = "SELECT * FROM `gatepasses` WHERE companyId = $cId";
	}
	else{
		$sql = "SELECT * FROM `gatepasses` WHERE companyId = $cId && status = '$status'";
	}
	$result = mysqli_query($con, $sql);
	$num = mysqli_num_rows($result);
	if ($num == 0) {
		echo 'Not Found';
	}
	else{
		echo "<option value=''>---Select Gatepass Number---</option>";
		for ($i=0; $i < $num; $i++) { 
			$data = mysqli_fetch_assoc($result);
			echo "<option value='". $data['gatepassNumber'] ."'>". $data['gatepassNumber'] ."</option>";
		}
	}