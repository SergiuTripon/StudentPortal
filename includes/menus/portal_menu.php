<?php
include '../session.php';
?>

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
        <li class="dropdown">
            <a id="find-out-more" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $firstname $surname ?> <span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu" role="menu">
            <li id="about"><a href="/about/">About</a></li>
            <li id="features"><a href="/features/">Features</a></li>
            <li id="user-manual"><a href="/user-manual/">User manual</a></li>
            <li id="contact"><a href="/contact/">Contact</a></li>
          </ul>
        </li>
    </ul>
    </div><!--/.nav-collapse -->
    </div><!--/.container -->
    </nav>
    <!-- End of Navigation -->