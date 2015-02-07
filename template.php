<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Template</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <!--[if lt IE 9]>
    <script src="https://student-portal.co.uk/js/html5shiv/html5shiv.min.js"></script>
    <script src="https://student-portal.co.uk/js/respond/respond.min.js"></script>
    <![endif]-->

    <style>
    .container .text-muted {
        margin: 20px 0;
    }

    code {
        font-size: 80%;
    }
    </style>


</head>

<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">Project name</a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
    <li class="active"><a href="#">Home</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact">Contact</a></li>
    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li class="divider"></li>
    <li class="dropdown-header">Nav header</li>
    <li><a href="#">Separated link</a></li>
    <li><a href="#">One more separated link</a></li>
    </ul>
    </li>
    </ul>
    </div><!--/.nav-collapse -->
    </div>
    </nav>

    <!-- Begin page content -->
    <div class="container">
    <form class="form-custom" name="signin_form" id="signin_form">

    <div class="form-logo">
	<i class="fa fa-graduation-cap"></i>
    </div>

    <hr class="hr-custom">

    <p id="error" class="feedback-sad text-center"></p>

    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="Enter an email address">
    <p id="error1" class="feedback-sad text-center"></p>

    <label>Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Enter a password">
    <p id="error2" class="feedback-sad text-center"></p>

    <div class="text-right">
    <a class="forgot-password" href="forgotten-password/">Forgotten your password?</a>
    </div>

    <hr class="hr-custom">

    <div class="pull-left">
    <a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href="register/"><span class="ladda-label">Register</span></a>
    </div>

    <div class="text-right">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-spinner-color="#333333" data-style="slide-up"><span class="ladda-label">Sign In</span></button>
	</div>

    </form>
    </div>

    <footer>
    <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
    </footer>

    <!-- js library -->
    <script src="https://student-portal.co.uk/assets/js/jquery/jquery-latest.min.js"></script>

    <!-- bootstrap -->
    <script src="https://student-portal.co.uk/assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- common-->
    <script src="https://student-portal.co.uk/assets/js/common/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
