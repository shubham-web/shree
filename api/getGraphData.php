<?php
	require_once 'middleware.php';
	require_once '../config.php';
	dbConnect();

	$sql = "SELECT MONTH(paymentDate) as month, YEAR(paymentDate) as year, SUM(paymentAmount) as paid FROM `payments` GROUP by MONTH(paymentDate), YEAR(paymentDate) ORDER by paymentDate DESC LIMIT 5";
	$result = mysqli_query($con, $sql);
	$rows = mysqli_num_rows($result);
	$output	= [];
	$monthArray = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	function getAmount($sql, $con)
	{
		$amount = mysqli_fetch_object(mysqli_query($con, $sql))->amt;
		if (!$amount) $amount = 0;
		return $amount;
	}
	for ($i=0; $i < 5; $i++) {
		if ($i >= $rows) { # if less than five rows are available
			array_push($output, ['month' => 'NA', 'sales' => '0', 'expenses' => '0']);
		}
		else{
			$data = mysqli_fetch_object($result);
			$month = $data->month;
			$monthStr = $monthArray[($data->month) - 1];
			$year = $data->year;

			$expenses = getAmount("SELECT SUM(amount) as amt FROM `expenses` WHERE MONTH(date) = $month AND YEAR(date) = $year", $con); # without tax

			$vouchers = getAmount("SELECT SUM(amount) as amt FROM `vouchers` WHERE MONTH(date) = $month AND YEAR(date) = $year", $con);

			$salary = getAmount("SELECT SUM(amount) as amt FROM `salary` WHERE MONTH(date) = $month AND YEAR(date) = $year", $con);

			$salesTax = getAmount("SELECT SUM(igst + sgst + cgst) as amt FROM bills WHERE MONTH(billDate) = $month AND YEAR(billDate) = $year AND billStatus = 1", $con);

			$totalExpenses = round($expenses + $vouchers + $salary + $salesTax);
			array_push($output, ['month' => $monthStr, 'sales' => $data->paid, 'expenses' => $totalExpenses]);
		}
	}
	echo json_encode($output);