<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	
	<link rel="stylesheet" href="style.css">
    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<title>Trader Dashboard</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<img src="logo.jpg">
		</a>
		<ul class="side-menu ">
			<li>
				<a href="#">
					<i class='bx bxs-home'></i>
					<span class="text">Home</span>
				</a>
			</li>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Order</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxl-product-hunt'></i>
					<span class="text">Product</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-bus'></i>
					<span class="text">Shipments</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-sort' ></i>
					<span class="text">Transaction</span>
				</a>
			</li>
			
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
		
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<a href="#" class="Cart">
				<i class='bx bxs-cart bx-md'></i>

				<span class="num">3</span>
			</a>
			<a href="#" class="profile">
				<img src="profile.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Trader Dashboard</h1>
					<ul class="breadcrumb">
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>$2543</h3>
						<p>Total Revenue</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-user'></i>
					<span class="text">
						<h3>120</h3>
						<p>Total Customers</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Top Five Traders</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Date Order</th>
								<th>Payment </th>
								<th>Order Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="user.png">
									<p>Preshna Adhikari</p>
								</td>
								<td>03-10-2024</td>
								<td style="text-align: center;"><span class="Esewa">Esewa</span></td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
									<img src="user.png">
									<p>Simran Shrestha</p>
								</td>
								<td>03-10-2024</td>
								<td style="text-align: center;"><span class="Esewa">Esewa</span></td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="user.png">
									<p>Riya Shrestha</p>
								</td>
								<td>03-10-2024</td>
								<td style="text-align: center;"><span class="Esewa">Esewa</span></td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>
									<img src="user.png">
									<p>Anshu Kharel</p>
								</td>
								<td>03-10-2024</td>
								<td style="text-align: center;"><span class="Esewa">Esewa</span></td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="user.png">
									<p>Aseena Subedi</p>
								</td>
								<td>03-10-2024</td>
								<td style="text-align: center;"><span class="Esewa">Esewa</span></td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Stat Overview</h3>
					</div>
                    <div id="piechart" style="width: 800px; height: 400px;"></div>
                </div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
    
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {

			var data = google.visualization.arrayToDataTable([
				['Task', 'Hours per Day'],
				['Work',     11],
				['Eat',      2],
				['Commute',  2],
				['Watch TV', 2],
				['Sleep',    7]
			]);

			var options = {
				title: 'My Daily Activities'
			};

			var chart = new google.visualization.PieChart(document.getElementById('piechart'));

			chart.draw(data, options);
		}
	</script>
	<script src="script.js"></script>
</body>
</html>
