	<style>
	html, body {
		height: 100% !important;
	}
	/* Menu master */
	.navbar-custom {
		margin-bottom: 0;
		background-color: #3D3D3D;
	}

	.navbar-custom .navbar-brand:focus {
		outline: 0;
	}
	
	.navbar-custom a {
		color: #FFA500;
	}
	
	.navbar-custom .navbar-brand {
		font-weight: 600;
	}
	
	.navbar-custom .nav li a {
		text-align: center;
		-webkit-transition: background .3s ease-in-out;
		-moz-transition: background .3s ease-in-out;
		transition: background .3s ease-in-out;
	}
	
	.navbar-custom .nav li.active {
		outline: none;
		background-color: #333333;
	}

	.navbar-custom .nav li a:hover,
	.navbar-custom .nav li a:focus,
	.navbar-custom .nav li a.active {
		outline: 0;
		background: none;
	}
	
	@media(max-width:767px) {
	.navbar-custom .navbar-toggle {
		padding: 4px 6px;
		font-size: 16px;
		color: #FFA500;
	}

	.navbar-custom .navbar-toggle:focus,
	.navbar-custom .navbar-toggle:active {
		outline: 0;
	}
	.navbar-header {
		border-bottom: 1px solid #FFA500;
	}
	.navbar-collapse {
		border-bottom: 1px solid #FFA500;
		border-top: none;
	}
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
        background-color: #3D3D3D;
    }

    .navbar-custom.top-nav-collapse {
        border-bottom: 1px solid #FFA500;
    }
	}
	/* End of Menu master */
	</style>
	
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
    <li class="hidden">
    <a href="#page-top"></a>
    </li>

	<li><a id="home" href="/">Home</a></li>

	<li><a id="about" href="/about/">About</a></li>

    <li><a id="features" href="/features/">Features</a></li>

	<li><a id="user-manual" href="/user-manual/">User Manual</a></li>

	<li><a id="contact" href="/contact/">Contact</a></li>

	</ul>
    </div>
    <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
    </nav>
