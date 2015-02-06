	<style>
	html, body {
		height: 100% !important;
	}
	/* Menu master */
	.navbar-custom {
    	margin-bottom: 0;
    	border-bottom: 1px solid rgba(255,255,255,.3);
    	background-color: #000;
	}

	.navbar-custom .navbar-brand {
    	font-weight: 700;
	}

	.navbar-custom .navbar-brand:focus {
    	outline: 0;
	}

	.navbar-custom .navbar-brand .navbar-toggle {
    	padding: 4px 6px;
    	font-size: 16px;
    	color: #fff;
	}

	.navbar-custom .navbar-brand .navbar-toggle:focus,
	.navbar-custom .navbar-brand .navbar-toggle:active {
    	outline: 0;
	}

	.navbar-custom a {
    	color: #fff;
	}

	.navbar-custom .nav li.active {
    	outline: none;
    	background-color: rgba(255,255,255,.3);
	}

	.navbar-custom .nav li a {
    	-webkit-transition: background .3s ease-in-out;
    	-moz-transition: background .3s ease-in-out;
    	transition: background .3s ease-in-out;
}

	.navbar-custom .nav li a:hover,
	.navbar-custom .nav li a:focus,
	.navbar-custom .nav li a.active {
    	outline: 0;
    	background-color: rgba(255,255,255,.3);
	}

	@media(min-width:767px) {
    .navbar {
        padding: 20px 0;
        border-bottom: 0;
        letter-spacing: 1px;
        background: 0 0;
        -webkit-transition: background .5s ease-in-out,padding .5s ease-in-out;
        -moz-transition: background .5s ease-in-out,padding .5s ease-in-out;
        transition: background .5s ease-in-out,padding .5s ease-in-out;
    }

    .top-nav-collapse {
        padding: 0;
        background-color: #000;
    }

    .navbar-custom.top-nav-collapse {
        border-bottom: 1px solid rgba(255,255,255,.3);
    }
	}

	/* End of Menu master */
	</style>
	
    <!-- Navigation -->
	<!-- Navigation -->
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
	<div class="container">
	<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
	<i class="fa fa-bars"></i>
	</button>
	<a class="navbar-brand page-scroll" href="#page-top">
	<i class="fa fa-graduation-cap"></i> Student Portal
	</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-right navbar-main-collapse">
	<ul class="nav navbar-nav">
	<!-- Hidden li included to remove active class from about link when scrolled up past about section -->
	<li class="hidden"><a href="#page-top"></a></li>

	<li><a id="signin" href="/about/">Sign In</a></li>
	<li><a id="register" href="/features/">Register</a></li>

	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="fa fa-caret-down"></span></a>
	<ul class="dropdown-menu" role="menu">
	<li><a id="about" href="/about/">About</a></li>
	<li><a id="features" href="/features/">Features</a></li>
	<li><a id="user-manual" href="/user-manual/">Contact</a></li>
	<li><a id="contact" href="/contact/">Contact</a></li>
	</ul>
	</li>

	</ul>
	</div><!-- /.navbar-collapse -->
	</div><!-- /.container -->
	</nav>
   	<!-- End of Navigation -->
