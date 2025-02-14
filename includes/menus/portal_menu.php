<?php
global $session_firstname;
global $session_surname;
?>

    <script>
    //Signs out the user currently signed in after 15 minutes of inactivity
    var inactivity;

    //Resets timeout
    function ResetTimeOut() {
        window.clearTimeout(inactivity);
        inactivity = window.setTimeout( "PageRedirect()" , 900000 );
    }

    //Where to redirect
    function PageRedirect() {
        window.location = "../../../sign-out-inactive.php";
    }

    //Setting 15 minute (900000 milliseconds) timeout
    window.onload = function() { setTimeout("PageRedirect()" , 900000 ) };

    //Reset timeout where a key is pressed or mouse is moved
    window.onmousemove = ResetTimeOut();
    window.onkeypress = ResetTimeOut();
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
            <a id="find-out-more" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $session_firstname, ' ', $session_surname; ?> <span class="fa fa-caret-down"></a>
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
