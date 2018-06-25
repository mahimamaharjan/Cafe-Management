<!DOCTYPE html>
<html>
<head>
	<title>Y.E.O.M</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">



    <!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
	<!-- <script type="text/javascript" src="js/script.js"></script> -->
</head>
<body>
	<header id="main-header">
		<div class="container">
			<div class="left-div">
				<h1><a href="index.php"> Y.E.O.M</a></h1>
			</div>
			<div class="right-div">
			<?php if(checkSession()): ?>
			Logged in as: <a href="profile.php"><?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']; ?></a>
			<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
	</header>


	<nav id="navbar">
		<div class="navContainer">
			<ul class="mainmenu">
				<li><a href="index.php">Home</a></li>
				<li class="hasSubmenu">
					<a href="#">Menu</a>
					<ul class="submenu">
						<?php
						$cf_list = getAllCafeList();
						if($cf_list):
							foreach($cf_list as $cf):
						?>
						<li class="child"><a href="menu.php?cafe=<?php echo $cf['id']; ?>"><?php echo $cf['name']; ?></a></li>
						<?php
							endforeach;
						endif;
						?>
					</ul>
                </li>
				<?php if(checkSession()): ?>
				<?php if($_SESSION['user_type'] == 'board_director'): ?>
				<li><a href="cafes.php">Cafes</a></li>
				<li><a href="staff.php">Staff</a></li>
				<li><a href="master_menu.php">Master Menu</a></li>
				<li><a href="cafe_menu_select.php">Cafe Menu</a></li>
				<li><a href="orders.php">Orders</a></li>
				<?php elseif($_SESSION['user_type'] == 'cafe_staff' || $_SESSION['user_type'] == 'cafe_manager'): ?>
				<li class="hasSubmenu">
					<a href="#">My Cafe</a>
					<ul class="submenu">
						<?php if($_SESSION['user_type'] == 'cafe_manager'): ?>
						<li class="child"><a href="my_cafe_menu_select.php">My Cafe Menu</a></li>
						<li class="child"><a href="my_cafe_hours.php">My Cafe Hours</a></li>
						<?php endif; ?>
						<li class="child"><a href="my_cafe_orders.php">My Cafe Orders</a></li>
					</ul>
                </li>
				<?php endif; ?>
				<?php
				$showAccountMenu = true;
				if(($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']) {
					$showAccountMenu = false;
				}
				?>
				<?php if($showAccountMenu): ?>
				<li class="hasSubmenu">
					<a href="#">My Account</a>
					<ul class="submenu">
						<li class="child"><a href="deposit_fund.php">Deposit Fund</a></li>
						<li class="child"><a href="profile.php">Profile</a></li>
						<li class="child"><a href="change_password.php">Change Password</a></li>
					</ul>
                </li>
				<?php endif; ?>
				<li><a href="logout.php">Log out</a></li>
				<?php else: ?>
				<li class="login"><a href="login.php">Log in</a></li>
				<li class="register"><a href="register.php">Register</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>
	<?php if(checkSession() && ($_SESSION['user_type'] == 'student' || $_SESSION['user_type'] == 'employee') && !$_SESSION['user_is_confirmed']): ?>
	<div class="container">
		<div class="warning-div">You have not yet confirmed your email address. Please check your email for the confirmation link.</div>
	</div>
	<?php endif; ?>
