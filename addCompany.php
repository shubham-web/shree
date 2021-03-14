<?php 
	require_once 'api/middleware.php';
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<link rel="stylesheet" href="css/vipForm" />
 	<link rel="stylesheet" href="css/snackbar.css" />

 	<title>Add Company Profile</title>
 </head>
 <body>
 	<img src="icon/back" id="backIcon" />
	 <form id="formToAddCompany">
		<h1 id="heading">New Company</h1>
		<img src="img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table>
				<tr>
					<td class="feildName">Company Name</td>
					<td><input type="text" id="cName" autocomplete="off" autofocus /></td>
				<tr>
					<td class="feildName">GSTIN</td>
					<td><input type="text" id="cGSTIN" maxlength="15" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Person I</td>
					<td><input type="text" id="cPerson1" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Number I</td>
					<td><input type="text" maxlength="10" autocomplete="off" id="cNumber1" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Person II</td>
					<td><input type="text" id="cPerson2" placeholder="Optional" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Number II</td>
					<td><input type="text" maxlength="10" autocomplete="off" id="cNumber2" placeholder="Optional" /></td>
				</tr>
				</tr>
				<tr>
					<td class="feildName">Address</td>
					<td><textarea id="cAddress" cols="30" rows="4"></textarea></td>
				</tr>
				<tr><td colspan="2" align="center"><button id="addCompany">Save Details</button></td></tr>
			</table>
			</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="js/addCompany.js"></script>
 	</footer>
 </body>
 </html>