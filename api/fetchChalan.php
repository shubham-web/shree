<?php 
require_once 'middleware.php';
require_once '../config.php';
dbConnect();
$cId = $_POST['cId'];
$gNumber = $_POST['gNumber'];
$chalans = mysqli_query($con, "SELECT number, date, rollsInfo FROM chalans WHERE companyId = $cId && gatepassNumber = '$gNumber'");
$totalChalans = mysqli_num_rows($chalans);
$output = array();
for ($i=0; $i < $totalChalans; $i++) {
	$chalan = mysqli_fetch_assoc($chalans);
	$chalanNumber = $chalan['number'];
	$chalanDate = $chalan['date'];
	$chalanDate = strtotime($chalanDate);
	$chalanDate = date("d-M-y", $chalanDate);
	$chalanInfo = json_decode($chalan['rollsInfo']);
	$numOfRolls = count($chalanInfo);
	for ($j=0; $j < $numOfRolls; $j++) { 
	$particular = $chalanInfo[$j];
	$push = array('number' => $chalanNumber, 'date' => $chalanDate, 'rolls' => $particular);
	array_push($output, $push);
	}
}
echo json_encode($output);