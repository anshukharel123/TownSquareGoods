<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	
	<link rel="stylesheet" href="style.css">

	<title>Customer Dashboard</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<img src="logo.jpg">
		</a>
		<ul class="side-menu">
    <div class="profile-logo">
        <img src="profile.png" alt="Profile">
    </div>
    <li>
            <a href="#">
                <span class="text">Full Name</span>
            </a>
        </li>
    </ul>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
                <i class='bx bx-user-circle'></i>
					<span class="text">My Profile</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Order</span>
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
					<span class="text">Questions</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Change password</span>
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
					<h1>Your Dashboard</h1>
					<ul class="breadcrumb">
                        <h2>Hello (Customer Name) !<br>From account dashboard you can edit your account details, change account password,view your orders and payments, track reviews  and questions.</br></h2>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user-rectangle medium-icon'></i>
					<span class="text">
						<p>My Profile</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<p>My Order</p>
					</span>
				</li>
                <li>
                <i class='bx bxs-credit-card-alt large-icon'></i>
					<span class="text">
						<p>Payments</p>
					</span>
				</li>
                <li>
                <i class='bx bx-comment-add'></i>
					<span class="text">
						<p>Review</p>
					</span>
				</li>
                <li>
                <i class='bx bx-question-mark'></i>
					<span class="text">
						<p>Question</p>
					</span>
				</li>
                <li>
                <i class='bx bxs-cog' ></i>
					<span class="text">
						<p>Change Password</p>
					</span>
				</li>
			</ul>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	

	<script src="script.js"></script>
</body>
</html>


