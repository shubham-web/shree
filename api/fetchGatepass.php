<?php 
	require_once '../config.php';
	require_once 'middleware.php';
	dbConnect();
	$gatepassNumber = $_GET['gatepassNumber'];
	$companyId = $_GET['companyId'];
	$fetchGatepass = "SELECT * FROM `gatepasses` WHERE gatepassNumber = '$gatepassNumber' AND companyId = $companyId";
	$exeG = mysqli_query($con, $fetchGatepass);
	$gatepassData = mysqli_fetch_assoc($exeG);
	$rollsInfo = $gatepassData['rollsInfo'];
	$rollsInfo = json_decode($rollsInfo, true);
	$fetchChalans = "SELECT rollsInfo FROM `chalans` WHERE gatepassNumber = '$gatepassNumber' AND companyId = $companyId";
	$exeC = mysqli_query($con, $fetchChalans);
	$totalChalans = mysqli_num_rows($exeC);
	if ($totalChalans == 0) {
		echo json_encode($rollsInfo);
	}
	else{
		$output = array();
		for ($i=0; $i < count($rollsInfo); $i++) {
			$push = array('quantity' => $rollsInfo[$i]['quantity'], 'description' => $rollsInfo[$i]['description']);
			$exeChalan = mysqli_query($con, $fetchChalans);
			$totalChalans = mysqli_num_rows($exeChalan);
			for ($j=0; $j < $totalChalans; $j++) {
				$chalanRolls = json_decode(mysqli_fetch_assoc($exeChalan)['rollsInfo']);
				for ($k=0; $k < count($chalanRolls); $k++) {
					if ($rollsInfo[$i]['description'] == $chalanRolls[$k][1]) {
						$push['quantity'] -= $chalanRolls[$k][0];
					}
				}
			}
			if ($push['quantity'] != 0) {	
				array_push($output, $push);
			}
		}
		echo json_encode($output);
	}