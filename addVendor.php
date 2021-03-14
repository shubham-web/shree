<?php require_once 'api/middleware.php'; ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/vipForm" />
	<link rel="stylesheet" href="css/msgBox" />
	<title>Add Vendor Profile</title>
 </head>
 <body>
<img src="icon/back" id="backIcon" />
<form>
	<h1 id="heading">New Vendor</h1>
	<img src="img/devider.png" alt="Devider" width="200" id="devider" />
	<div id="inputWrapper">
	<table>
		<tr>
			<td class="feildName">Vendor Name</td>
			<td><input type="text" id="name" autofocus /></td>
		<tr>
		    <td class="feildName">GSTIN</td>
			<td><input type="text" id="gstin" maxlength="15" /></td>
		</tr>
		<tr>
			<td class="feildName">Address</td>
			<td><input type="text" id="address" /></td>
		</tr>
		<tr>
			<td class="feildName">Description</td>
			<td><textarea cols="30" id="desc" placeholder="Optional" rows="4"></textarea></td>
		</tr>
		<tr><td colspan="2" align="center"><button id="addVendor">Save Details</button></td></tr>
	</table>
	</div>
</form>
<span id="message"></span>
<footer>
	<script src="js/addVendor.js"></script>
</footer>
</body>
</html>