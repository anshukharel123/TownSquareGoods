<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	
	<link rel="stylesheet" href="style.css">

	<title>Admin Dashboard</title>
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
					<span class="text">View Order</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Edit Order</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxl-product-hunt'></i>
					<span class="text">View all Product</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxl-product-hunt'></i>
					<span class="text">Edit all Product</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-credit-card-alt'></i>
					<span class="text">Payment</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-comment-add'></i>
					<span class="text">Review</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-question-mark' ></i>
					<span class="text">Query</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-user-rectangle'></i>
					<span class="text">View all Traders</span>
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
					<h1>Admin Dashboard</h1>
					<ul class="breadcrumb">
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>$2543</h3>
						<p>Total Sales</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>1020</h3>
						<p>New Order</p>
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
								<j/td>
								<td>03-10-2024</td>
								<td style="text-align: center;"><span class="Esewa">Esewa</span></td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Total Customers</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Aseena Subedi</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Riya Stha</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Simran Stha</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Anshu Kharel</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Preshna Adhikari</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
					</ul>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	

	<script src="script.js"></script>
</body>
</html>


