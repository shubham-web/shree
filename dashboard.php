<?php 
	require_once 'api/middleware.php';
	require_once 'config.php';
	dbConnect();
	$billsThisMonth = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as billsThisMonth FROM `bills` WHERE MONTH(billDate) = MONTH(CURRENT_DATE) AND YEAR(billDate) = YEAR(CURRENT_DATE)"))['billsThisMonth'];

	$pendingGatepasses = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as pendingGatepasses FROM `gatepasses` WHERE status = 'Pending'"))['pendingGatepasses'];

	$totalEmployees = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as totalEmployees FROM `employees`"))['totalEmployees'];

	$totalVendors = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as totalVendors FROM `vendors`"))['totalVendors'];	

	//  For Recent Gate-passes
	$recentGatepasses = mysqli_query($con, "SELECT companyId, gatepassNumber, gatepassDate, status FROM `gatepasses` ORDER BY `gatepassDate` DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/dashboard" />
	<link rel="stylesheet" href="css/customContext" />
	<link rel="icon" href="favicon" />
	<title>Dashboard | Shree Engineering Works</title>
</head>
<body>
	<!-- ----------------------------------------------------------------- -->
	<!-- ----------------------Left-Sidebar-Menu-------------------------- -->
	<aside id="sidebarMenu">
		<h1 id="siteTitle"><img src="logo" alt="Shree" id="logo"/></h1>
		<button class="menuItem active" id="home" disabled="">
			<img src="icon/home" class="menuIcon">
			Home
		</button>
		<button class="menuItem" id="manageGatepass">
			<img src="icon/pass" class="menuIcon">
			Gatepasses
		</button>
		<button class="menuItem" id="manageChalans">
			<img src="icon/chalan" class="menuIcon">
			Chalans
		</button>
		<button class="menuItem" id="manageBills">
			<img src="icon/bill" class="menuIcon">
			Bills
		</button>
		<button class="menuItem" id="managePayment">
			<img src="icon/payment" class="menuIcon">
			Payments
		</button>
		<button class="menuItem" id="expenses">
			<img src="icon/expenses" class="menuIcon">
			Expenses
		</button>
		<button class="menuItem" id="reports">
			<img src="icon/reports" class="menuIcon">
			Reports
		</button>
		<hr>
		<button class="menuItem" id="employee">
		<img src="icon/employee" class="menuIcon">
		Employees
		</button>
		<button class="menuItem" id="vouchers">
		<img src="icon/vouchers" class="menuIcon">
		Vouchers
		</button>

		<button class="menuItem" id="more" disabled="">
			<img src="icon/more" class="menuIcon">
			More
		</button>
		<div id="moreItems" class="extraNavigation">
			<button class="menuItem" id="company">
				<img src="icon/factory" class="menuIcon">
				Companies
			</button>
			<button class="menuItem" id="vendors">
				<img src="icon/vendors" class="menuIcon">
				Vendors
			</button>
			<button class="menuItem" id="trash">
				<img src="icon/trash" class="menuIcon">
				Trash Items
			</button>
		</div>
		<button class="menuItem" id="logout">
			<img src="icon/logout" class="menuIcon">
			Logout
		</button>
	</aside>
	<!-- ----------------------------------------------------------------- -->
	<!-- ---------------------Right-Section-Dashboard--------------------- -->
	<section id="dashboard">
		<header>
			<h1 id="headerHeading">Dashboard</h1>
			<span id="email">
				<?php echo strtolower($_SESSION['email']); ?>
				<img src="icon/down-arrow" id="arrow" width="10" />
				<span id="logoutText" style="display: none;">LOGOUT</span>
			</span>
		</header>
		<hr>
		<div id="container">
			<div id="loader"><span>Loading...</span></div>
			<div id="mainWrapper">
				<section class="accorrdionWrapper">
				<main id="statisticsWrapper">
					<h1>
						Statistics - <span id="year"></span>
						<img src="icon/statistics" id="statisticsIcon" />
					</h1>
					<nav id="statisticsNav">
						<ul>
							<a href="" id="first" class="activeStatistics"><li>Bills</li></a>
							<a href="" id="second"><li>Purchase</li></a>
							<a href="" id="third"><li>GatePasses</li></a>
							<a href="" id="fourth"><li>Sales</li></a>
							<a href="" id="fifth"><li>Payments</li></a>
						</ul>
						<span id="activeBar"></span>
					</nav>
					<div class="dataRoot">
						<section id="stcsBills" class="statisticsData">
							<div class="left">
							<aside class="circle"></aside>
							<span id="digit">23</span>
							</div>
							<div class="right">
								<ul type="square">
									<li>*Static</li>
									<li>Total Bills : 23</li>
									<li>Worth Rs. 325000</li>
									<li>Payment Rs. 11000</li>
								</ul>
							</div>
						</section>
						<section class="statisticsData">
							<p>Purchase</p>
						</section>
						<section class="statisticsData">
							<p>Gatepass</p>
						</section>
						<section class="statisticsData">
							<p>Sales</p>
						</section>
						<section class="statisticsData">
							<p>Payments</p>
						</section>
					</div>
				</main>
					<div class="accordionBox">
						<img src="img/delivery-truck.png" class="dataIcon" id="dataIcon1" />
						<h1 class="accordionHead" id="head1">
							<img src="icon/recent" class="icon">
							Recent Gatepasses
							<img src="icon/expand" class="expandArrow"  id="arrow1" />
						</h1>
						<ul class="accordionData" id="data1">
							<?php 
								$recentGatepassesRows = mysqli_num_rows($recentGatepasses);
								if ($recentGatepassesRows == 0) {
									echo "<li><b></b> -------------------------- <i></i></li>";
									echo "<li><b></b> No Recent Gatepasses Found <i></i></li>";
									echo "<li><b></b> -------------------------- <i></i></li>";
								}
								else{
									for ($i=0; $i < $recentGatepassesRows; $i++) {
										$data = mysqli_fetch_assoc($recentGatepasses);
										$cId = $data['companyId'];
										$companyName = mysqli_fetch_assoc(mysqli_query($con, "SELECT name from companies WHERE id = $cId"))['name'];
										if ($data['status'] == 'Pending') {
											echo "<li style='color:#f7ad00;'>";
										}
										else{
											echo "<li style='color:#4cda65;'>";
										}
										echo "<b>".$data['gatepassNumber']."</b> <i>".$companyName."</i></li>";
									}
								}
							?>
						</ul>
					</div>
					<div class="accordionBox">
						<img src="img/growth.png" class="dataIcon" id="dataIcon2" />
						<h1 class="accordionHead" id="head2">
							<img src="icon/report" class="icon" />
							Generate Reports
							<img src="icon/expand" class="expandArrow" id="arrow2" />
						</h1>
						<ul class="accordionData" id="data2">
							<li class="clickable" id="report1">Sales Report</li>
							<li class="clickable" id="report2">Purchase Report</li>
							<li class="clickable" id="report3">Company Wise Reports</li>
						</ul>
					</div>
					<div class="accordionBox">
						<img src="img/calculate.png" class="dataIcon" id="dataIcon3" />
						<h1 class="accordionHead" id="head3">
							<img src="icon/vouchers" class="icon" />
							Vouchers
							<img src="icon/expand" class="expandArrow"  id="arrow3" />
						</h1>
						<ul class="accordionData" id="data3">
							<li>List item 1</li>
							<li>List item 2</li>
							<li>List item 3</li>
						</ul>
					</div>
					<div class="accordionBox">
						<img src="img/approve.png" class="dataIcon" id="dataIcon4" />
						<h1 class="accordionHead" id="head4">
							<img src="icon/invoice" class="icon">
							Recent Bills
							<img src="icon/expand" class="expandArrow"  id="arrow4" />
						</h1>
						<ul class="accordionData" id="data4">
							<?php 
								$sql = "SELECT bills.billNumber, companies.name FROM `bills` INNER JOIN companies ON bills.companyId = companies.id ORDER BY bills.id DESC LIMIT 3";
								$recentBills = mysqli_query($con, $sql);
								$bills = mysqli_num_rows($recentBills);
								for ($i=0; $i < $bills; $i++) {
									$data = mysqli_fetch_assoc($recentBills);
									echo "<li class='clickable' onclick=\"launch('".$data['billNumber']."')\" >".$data['billNumber']." - ".$data['name']."</li>";
								}
							?>
						</ul>
					</div>
				</section>
				<section class="todoWrapper">
					<div class="todoApp">
						<header id="todoHeader">
							<span id="day"></span>
							<span id="undoneTasks" title="Incompleted Tasks">{{ Tasks }}</span>
							<span id="month"></span>
							<section id="middleAction">
								<input type="text" id="newTaskInput" placeholder="Brief Your Task" autocomplete="off"  maxlength="500" />
								<button id="addTodo" title="Add Task">+</button>
							</section>
						</header>
						<main id="todos"></main>
					</div>
				</section>
			</div>
		</div>
	</section>
	<ul id="contextMenu">
		<li class="contextMenuItem">Reload</li>
		<li class="contextMenuItem">Gatepasses</li>
		<li class="contextMenuItem">Manage Bills</li>
		<li class="contextMenuItem" id="fullScreenLi"></li>
		<li class="contextMenuItem">Log out</li>
	</ul>
	<audio src="sounds/notify.mp3" id="notifySound"></audio>
	<footer><script src="js/dashboard"></script></footer>
</body>
</html>