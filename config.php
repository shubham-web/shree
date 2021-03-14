<?php 
	$uri = explode('/', $_SERVER['SCRIPT_NAME']);
	$uri = $uri[count($uri) - 1];
	if ($uri == 'config.php') die("Direct Access Not Allowed"); 
	
	// For Database Connection
	$GLOBALS['server'] = 'localhost'; // Server Name
	$GLOBALS['user'] = 'root'; // Database username
	$GLOBALS['serverPassword'] = ''; // Database password
	$GLOBALS['dbName'] = 'shree'; // Database Name
	
	//--------------------------------- Bill's  Details -----------------------
	$GLOBALS['title'] = "Shree Engineering Works"; // Below Company Title
	$GLOBALS['subTitle'] = "C-I,Chilled Roll Grinding , Grooving & Manufacturing Works"; // Below Company Title
	$GLOBALS['workAddress'] = "7/1B Industrial Area No. 2, A.B. Road Dewas(M.P.)455001"; // Work Address
	$GLOBALS['officeAddress'] = "27, Gomti Nagar,Dewas (M.P.) 455001"; // Office Address
	$GLOBALS['gstin'] = "23AAOPJ2936N1ZC"; // Company's GSTIN
	
	// Bank Details
	$GLOBALS['bankName'] = "BANK OF INDIA INDUSTRIAL AREA NO.2";
	$GLOBALS['accountNumber'] = "890120110000464";
	$GLOBALS['ifscCode'] = "BKID0008901";

	// Tax Percentages
	$GLOBALS['CGST_RATE'] = 9;  // In Percentage
	$GLOBALS['SGST_RATE'] = 9;  // In Percentage
	$GLOBALS['IGST_RATE'] = 18;  // In Percentage
