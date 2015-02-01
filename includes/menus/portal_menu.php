<?php
include '../signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

$stmt1 = $mysqli->prepare("SELECT user_signin.userid, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid LEFT JOIN user_fees ON user_signin.userid=user_fees.userid WHERE user_signin.userid = ? LIMIT 1");
$stmt1->bind_param('i', $userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($userid, $firstname, $surname);
$stmt1->fetch();

?>

	<style>
	.solid-backround {
		background-color: #333333 !important;
	}

	.solid-backround:hover, .solid-backround:focus {
		background-color: #333333 !important;
	}
	
	/* Portal Menu */
	.navbar {
		background-color: #333333;
		border-color: #FFA500;
		border-radius: 0px;
		margin-top: 20px;
		margin-bottom: 30px;
	}

	.navbar-default .navbar-collapse, .navbar-default .navbar-form {
		border-color: #FFA500;
	}

	.navbar-brand {
		color: #FFA500;
		font-size: 40px;
		padding: 5px;
		padding: 0px;
		border-right: 1px solid #FFA500;
	}
	.navbar-brand i {
		color: #FFA500;
		font-size: 40px;
		padding: 5px;
	}

	.navbar-default .navbar-toggle:hover,
	.navbar-default .navbar-toggle:focus {
		background: none;
	}

	.navbar-default .navbar-toggle {
		border-color: #FFA500;	
	}
	
	.navbar-toggle {
		border-radius: 0px;
		margin-right: 10px;
	}
	
	.navbar-nav {
		margin: 0px -15px;
	}

	.navbar-default .navbar-toggle .icon-bar {
		background-color: #FFA500;
	}

	.navbar-default .navbar-nav>li>a {
		color: #FFA500;
	}

	.navbar-default .navbar-nav>li>a:hover,
	.navbar-default .navbar-nav>li>a:focus {
		color: #FFA500;
	}
	
	.dropdown-menu {
		color: #FFA500;
		border: 1px solid #FFA500;
		background-color: #333333;
	}

	.dropdown-menu>li>a {
		color: #FFA500;
	}

	.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus  {
		color: #333333;
		background-color: #FFA500;
	}

	.dropdown-menu .divider {
		background-color: #FFA500;
	}
	
	.navbar-default .navbar-nav>.open>a,
	.navbar-default .navbar-nav>.open>a:hover,
	.navbar-default .navbar-nav>.open>a:focus {
		color: #FFA500;
		background: none;
	}
	
	@media (max-width: 767px) {
	.navbar-default .navbar-nav .open .dropdown-menu>li>a,
	.navbar-default .navbar-nav .open .dropdown-menu>li>a:hover,
	.navbar-default .navbar-nav .open .dropdown-menu>li>a:focus {
		color: #FFA500;
		text-align: center;
	}
	}
	
	@media (min-width: 768px) {
	.container-fluid {
		padding-right: 0px;
	}
	}
	
	@media (max-width: 768px) {
	.navbar {
		margin-bottom: 20px !important;
	}
	.navbar-default .navbar-nav>li>a {
		text-align: center;
	}
	}
	/* End of Portal Menu */
	
	</style>
	
    <!-- Portal Menu -->	
	<div class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
    
    <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
   	<span class="icon-bar"></span>
 	<span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
   	<a class="navbar-brand" href="">
	<i class="fa fa-graduation-cap"></i>
    </a>
    </div>
    
    <div class="navbar-collapse collapse">
    
    <ul class="nav navbar-nav navbar-right">
    
    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><?php echo "$firstname $surname"; ?></b> <span class="fa fa-chevron-down"></span></a>
    <ul class="dropdown-menu" role="menu">
    <li><a href="../update-account/">Update personal details</a></li>
   	<li><a href="../change-password/">Change password</a></li>
    <li class="divider"></li>
    <li><a href="../../sign-out/">Sign Out</a></li>
    </ul>
    </li>
    
    </ul>
    
    </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
    </div><!--/.navbar -->
	<!-- End of Portal Menu -->
