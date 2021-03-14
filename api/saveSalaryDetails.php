<?php 
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect() or die("Database Connection Failed");
	$salaryDate = $_POST['date'];
	$attendance = $_POST['attendance'];
	$attendance = json_decode($attendance, true);
	$saved = false;
	for ($i=0; $i < count($attendance); $i++) {
		$employeeId = $attendance[$i]['id'];
		$salary = mysqli_fetch_assoc(mysqli_query($con, "SELECT salary FROM employees WHERE id = $employeeId"))['salary'];
		$workingDays = $attendance[$i]['days'];
		$amount = $salary * $workingDays;
		$sql ="INSERT INTO `salary`(`employeeId`, `workingDays`, `date`, `amount`) VALUES ($employeeId, '$workingDays', '$salaryDate', $amount)";
		$result = mysqli_query($con, $sql);

		$saved = $result;

		if (!$saved){
			$sql = "DELETE from salary WHERE date = '$salaryDate'";
			$result = mysqli_query($con, $sql);
			break;
		}
	}
	echo ($saved) ? "1":"0";