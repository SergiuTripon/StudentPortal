<?php
global $session_firstname;
global $session_surname;
?>

    <script>
    var timeOut;
    function reset() {
        window.clearTimeout(timeOut);
        timeOut = window.setTimeout( "redir()" , 900000 );
    }
    function redir() {
        window.location = "../../../sign-out-inactive.php";
    }
    window.onload = function() { setTimeout("redir()" , 900000 ) };
    window.onmousemove = reset();
    window.onkeypress = reset();
    </script>

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
    <a class="navbar-brand" href="/home/"><i class="fa fa-graduation-cap"></i> Student Portal</a>
    </div>

    <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a id="find-out-more" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $session_firstname, ' ', $session_surname; ?> <span class="fa fa-caret-down"></span></a>
            <ul class="dropdown-menu" role="menu">
            <li><a href="/account/update-account/">Update account</a></li>
            <li><a href="/account/change-password/">Change password</a></li>
            <li><a href="/account/pay-course-fees/">Pay course fees</a></li>
            <li><a href="/account/delete-account/">Delete account</a></li>
          </ul>
        </li>
        <li id="signout"><a href="/sign-out/">Sign Out</a></li>
    </ul>
    </div><!--/.nav-collapse -->
    </div><!--/.container -->
    </nav>
    <!-- End of Navigation -->
