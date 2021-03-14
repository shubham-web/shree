<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$id = $_GET['id'];
	$sql = "SELECT * FROM `vendors` WHERE id=$id";
	$execute = mysqli_query($con, $sql);
	$num = mysqli_num_rows($execute);
	if ($num > 0) {
		$data = mysqli_fetch_assoc($execute);
?>
<link rel="stylesheet" href="css/addCompany.css" />
<link rel="stylesheet" href="css/snackbar.css" />
<img src="img/icon/back.png" id="backIcon" />
	 <form>
		<h1 id="heading">Update Vendor Details</h1>
		<img src="img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table>
				<tr>
					<td class="feildName">Vendor Name</td>
					<td><input id="name" type="text" value="<?php echo $data['name']; ?>" /></td>
				<tr>
					<td class="feildName">GSTIN</td>
					<td><input id="gstin" type="text" value="<?php echo $data['gstin']; ?>" maxlength="15" /></td>
				</tr>
				<tr>
					<td class="feildName">Address</td>
					<td><input id="address" type="text" value="<?php echo $data['address']; ?>" /></td>
				</tr>
				<tr>
					<td class="feildName">Description</td>
					<td>
						<textarea id="description" placeholder="Optional" cols="30" rows="4"><?php echo $data['description']; ?></textarea>
						<input type="hidden" id="id" value="<?php echo $data['id']; ?>" />
					</td>
				</tr>
				<tr><td colspan="2" align="center"><button id="updateVendor">Update</button></td></tr>
			</table>
			</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="js/editVendor.js"></script>
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