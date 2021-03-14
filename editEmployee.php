<?php 
	require_once 'config.php';
	require_once 'api/middleware.php';
	dbConnect();
	$id = $_GET['id'];
	$sql = "SELECT * FROM `employees` WHERE id=$id";
	$execute = mysqli_query($con, $sql);
	$num = mysqli_num_rows($execute);
	if ($num > 0) {
		$data = mysqli_fetch_assoc($execute);
?>
<link rel="stylesheet" href="../css/addCompany.css" />
<link rel="stylesheet" href="../css/snackbar.css" />
<img src="../icon/back" id="backIcon" />
	 <form id="formToAddCompany">
		<h1 id="heading">Edit Employee Details</h1>
		<img src="../img/devider.png" alt="Devider" width="200" id="devider" />
		<div id="inputWrapper">
			<table width="80%">
				<tr>
					<td class="feildName">Name</td>
					<td><input type="text" id="name" value="<?php echo $data['name']; ?>" autocomplete="off" autofocus /></td>
				<tr>
					<td class="feildName">Qualification</td>
					<td><input type="text" id="edu" value="<?php echo $data['qualification']; ?>" maxlength="15" /></td>
				</tr>
				<tr>
					<td class="feildName">Contact</td>
					<td><input type="text" id="mobile" value="<?php echo $data['mobileNumber']; ?>" maxlength="10" />
						<input type="hidden" id="id" value="<?php echo $data['id']; ?>" />
					</td>
				</tr>
				<tr>
					<td class="feildName">Aadhar</td>
					<td><input type="text" maxlength="12" value="<?php echo $data['aadhar']; ?>"  autocomplete="off" id="aadhar" /></td>
				</tr>
				<tr>
					<td class="feildName">Joining Date</td>
					<td><input type="date" value="<?php echo $data['joiningDate']; ?>" id="date"/></td>
				</tr>
				<tr>
					<td class="feildName">Salary</td>
					<td><input type="text" maxlength="10" value="<?php echo $data['salary']; ?>" autocomplete="off" id="salary" /></td>
				</tr>
				</tr>
				<tr><td colspan="2" align="center"><button id="addEmployee">Update</button></td></tr>
			</table>
		</div>
 </form>
 <span id="message"></span>
 	<footer>
 		<script src="../js/editEmployee.js"></script>
 	</footer>
<?php
	}
	else{
		echo "Error";
		die();
	}
 ?>