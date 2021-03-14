<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<link rel="stylesheet" href="css/vipForm" />
 	<link rel="stylesheet" href="css/msgBox" />
 	<title>Add Employee</title>
 </head>
 <body>
 	<img src="icon/back" id="backIcon" />
	 <form id="formToAddCompany">
		<h1 id="heading">New Employee</h1>
		<img src="img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table width="80%">
				<tr>
					<td class="feildName">Name</td>
					<td><input type="text" id="name" autocomplete="off" autofocus /></td>
				<tr>
					<td class="feildName">Qualification</td>
					<td><input type="text" id="edu" maxlength="15" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact</td>
					<td><input type="text" id="mobile" maxlength="10" /></td>
				</tr>
				<tr>
					<td class="feildName">Aadhar</td>
					<td><input type="text" maxlength="12" autocomplete="off" id="aadhar" /></td>
				</tr>
				<tr>
					<td class="feildName">Joining Date</td>
					<td><input type="date" id="date"/></td>
				</tr>
				<tr>
					<td class="feildName">Salary</td>
					<td><input type="text" maxlength="10" autocomplete="off" id="salary" /></td>
				</tr>
				</tr>
				<tr><td colspan="2" align="center"><button id="addEmployee">Save</button></td></tr>
			</table>
		</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="js/addEmployee.js"></script>
 	</footer>
 </body>
 </html>