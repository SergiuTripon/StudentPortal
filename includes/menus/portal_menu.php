    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
    <div class="navbar-header">
    <!-- Toggle -->
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    <!-- End of Toggle -->
    <a class="navbar-brand" href=""><i class="fa fa-graduation-cap"></i> Student Portal</a>
    </div>

    <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">
        <li><a href=""><?php echo $session_firstname, ' ', $session_surname; ?></a></li>
        <li id="signout"><a href="/sign-out/">Sign Out</a></li>
    </ul>
    </div><!--/.nav-collapse -->
    </div><!--/.container -->
    </nav>
    <!-- End of Navigation -->
