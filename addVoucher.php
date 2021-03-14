<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8" />
 	<link rel="stylesheet" href="css/vipForm" />
 	<link rel="stylesheet" href="css/snackbar.css" />
 	<title>Add Expenditure</title>
 </head>
 <body>
 	<img src="icon/back" id="backIcon" />
	 <form id="formToAddCompany">
		<h1 id="heading">Add Expenditure</h1>
		<img src="img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table width="80%">
				<tr>
					<td class="feildName">Date</td>
					<td><input type="date" id="date" /></td>
				<tr>
					<td class="feildName">Amount</td>
					<td><input type="text" id="amount" placeholder="INR" autofocus autocomplete="off" maxlength="15" /></td>
				</tr>
				<tr>
					<td class="feildName">Receiver</td>
					<td><input type="text" id="receiver" placeholder="Paid to" /></td>
				</tr>
				<tr>
					<td class="feildName">Description</td>
					<td><textarea id="description" placeholder="Optional" cols="10" rows="3"></textarea></td>
				</tr>
				<tr><td colspan="2" align="center"><button id="saveVoucher">Save</button></td></tr>
			</table>
		</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="js/addVoucher.js"></script>
 	</footer>
 </body>
 </html>