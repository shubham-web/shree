<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$id = $_GET['id'];
	$sql = "SELECT * FROM `companies` WHERE id=$id";
	$execute = mysqli_query($con, $sql);
	$num = mysqli_num_rows($execute);
	if ($num > 0) {
		$data = mysqli_fetch_assoc($execute);
?>
<link rel="stylesheet" href="../css/addCompany.css" />
<link rel="stylesheet" href="../css/snackbar.css" />
<img src="../icon/back" id="backIcon" />
	 <form id="formToAddCompany">
		<h1 id="heading">Update Company Details</h1>
		<img src="../img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table>
				<tr>
					<td class="feildName">Company Name</td>
					<td><input type="text" value="<?php echo $data['name']; ?>" id="cName" /></td>
				<tr>
					<td class="feildName">GSTIN</td>
					<td><input type="text" value="<?php echo $data['gstin']; ?>" id="cGSTIN" maxlength="15" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Person I</td>
					<td><input type="text" value="<?php echo $data['contactPerson1']; ?>" id="cPerson1" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Number I</td>
					<td><input type="text" maxlength="10" value="<?php echo $data['contactNumber1']; ?>" autocomplete="off" id="cNumber1" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Person II</td>
					<td><input type="text" value="<?php echo $data['contactPerson2']; ?>" id="cPerson2" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact Number II</td>
					<td><input type="text" maxlength="10" value="<?php echo $data['contactNumber2']; ?>" autocomplete="off" id="cNumber2" /></td>
				</tr>
				</tr>
				<tr>
					<td class="feildName">Address</td>
					<td>
						<textarea id="cAddress" cols="30" rows="4"><?php echo $data['address']; ?></textarea>
						<input type="hidden" id="cId" value="<?php echo $data['id']; ?>" />
					</td>
				</tr>
				<tr><td colspan="2" align="center"><button id="addCompany">Update</button></td></tr>
			</table>
			</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="../js/editCompany.js"></script>
 	</footer>
<?php
	}
	else{
		echo "Error";
		die();
	}
 ?>
 <script>
 	let backBtn = document.querySelector('#backIcon')
 	backBtn.addEventListener('click', function (event) {
 		window.history.back()
 	})
 </script>