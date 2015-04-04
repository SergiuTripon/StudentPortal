<?php
include 'includes/session.php';

global $video_selector;

if (isset($_GET["video"])) {
    $video_selector = $_GET["video"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>
    <?php include 'assets/css-paths/ekko-lightbox-css-path.php'; ?>

    <title>Student Portal | Usability testing</title>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

     <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="usability-testing-showcase" class="container">

    <h1 class="text-center">Usability testing</h1>
    <hr class="hr-small">

	<p class="text-left">Click to watch the videos</p>

    <div class="row">
    <a href="https://www.youtube.com/watch?v=AJoGdJwocQ8" data-toggle="lightbox" data-type="youtube" data-title="Timetable (0:00)">
    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<div class="tile large-tile">
    <i class="fa fa-clock-o"></i>
	<p>Timetable</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=AJoGdJwocQ8" data-toggle="lightbox" data-type="youtube" data-title="Exams (1:50)">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Exams</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=AJoGdJwocQ8" data-toggle="lightbox" data-type="youtube" data-title="Results (2:50)">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Results</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/vSVTuCNUWXM" data-toggle="lightbox" data-type="youtube" data-title="Transport">
    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<div class="tile">
    <i class="fa fa-bus"></i>
	<p>Transport</p>
    </div>
	</div>
	</a>

    <a href="https://www.youtube.com/embed/Ntq0qCIr7Qo" data-toggle="lightbox" data-type="youtube" data-title="Library">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p>Library</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/pjyUITZScrU" data-toggle="lightbox" data-type="youtube" data-title="Calendar">
    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-calendar"></i>
	<p>Calendar</p>
	</div>
	</div>
	</a>

    <a href="https://www.youtube.com/embed/jWVqzzC1d3o" data-toggle="lightbox" data-type="youtube" data-title="University map">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div class="tile">
    <i class="fa fa-map-marker"></i>
	<p>University Map</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/vnF_P613aPs" data-toggle="lightbox" data-type="youtube" data-title="Events">
    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<div class="tile">
	<i class="fa fa-ticket"></i>
	<p>Events</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/_TVZ9sqyvho" data-toggle="lightbox" data-type="youtube" data-title="Feedback">
    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p>Feedback</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/e2u27XFd36M" data-toggle="lightbox" data-type="youtube" data-title="Messenger">
    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-comments"></i>
	<p>Messenger</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=sH_HzsFCb1Y" data-toggle="lightbox" data-type="youtube" data-title="Account">
    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-user"></i>
	<p>Account</p>
	</div>
	</div>
    </a>
	</div><!-- /.row -->

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="usability-testing-showcase" class="container">

    <h1 class="text-center">Usability testing</h1>
    <hr class="hr-small">

	<p class="text-left">Click to watch the videos</p>

    <div id="video-selector" style="display: none;"><?php echo $video_selector ?></div>

    <div class="row">

    <a href="https://www.youtube.com/watch?v=9GPDNgL1WP0" data-toggle="lightbox" data-type="youtube" data-title="Full video" id="video-full-video">
    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
	<div class="tile">
    <i class="fa fa-youtube-play"></i>
	<p>Full video</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=s-l2RMIoKMo" data-toggle="lightbox" data-type="youtube" data-title="Sign In" id="video-sign-in">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-sign-in"></i>
	<p>Sign In</p>
	</div>
	</div>
    </a>


    <a href="https://www.youtube.com/watch?v=IAkrF44858k" data-toggle="lightbox" data-type="youtube" data-title="Register (0:00)" id="video-register">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-user-plus"></i>
	<p>Register</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=IAkrF44858k" data-toggle="lightbox" data-type="youtube" data-title="Forgotten your password (1:17)" id="video-forgotten-password">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div class="tile">
    <i class="fa fa-lock"></i>
	<p>Forgotten your password</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=IAkrF44858k" data-toggle="lightbox" data-type="youtube" data-title="Password reset (3:01)" id="video-password-reset">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-unlock"></i>
	<p>Password reset</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=AJoGdJwocQ8" data-toggle="lightbox" data-type="youtube" data-title="Timetable (0:00)" id="video-timetable">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-clock-o"></i>
	<p>Timetable</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=AJoGdJwocQ8" data-toggle="lightbox" data-type="youtube" data-title="Exams (1:50)" id="video-exams">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Exams</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=AJoGdJwocQ8" data-toggle="lightbox" data-type="youtube" data-title="Results (2:50)" id="video-results">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-trophy"></i>
	<p>Results</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/vSVTuCNUWXM" data-toggle="lightbox" data-type="youtube" data-title="Transport" id="video-transport">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-bus"></i>
	<p>Transport</p>
    </div>
	</div>
	</a>

    <a href="https://www.youtube.com/embed/Ntq0qCIr7Qo" data-toggle="lightbox" data-type="youtube" data-title="Library" id="video-library">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p>Library</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/pjyUITZScrU" data-toggle="lightbox" data-type="youtube" data-title="Calendar" id="video-calendar">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-calendar"></i>
	<p>Calendar</p>
	</div>
	</div>
	</a>

    <a href="https://www.youtube.com/embed/jWVqzzC1d3o" data-toggle="lightbox" data-type="youtube" data-title="University map" id="video-university-map">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-map-marker"></i>
	<p>University Map</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/vnF_P613aPs" data-toggle="lightbox" data-type="youtube" data-title="Events" id="video-events">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
	<i class="fa fa-ticket"></i>
	<p>Events</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/_TVZ9sqyvho" data-toggle="lightbox" data-type="youtube" data-title="Feedback" id="video-feedback">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p>Feedback</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/embed/e2u27XFd36M" data-toggle="lightbox" data-type="youtube" data-title="Messenger" id="video-messenger">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-comments"></i>
	<p>Messenger</p>
	</div>
	</div>
    </a>

    <a href="https://www.youtube.com/watch?v=sH_HzsFCb1Y" data-toggle="lightbox" data-type="youtube" data-title="Account" id="video-account">
    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div class="tile">
    <i class="fa fa-user"></i>
	<p>Account</p>
	</div>
	</div>
    </a>
	</div><!-- /.row -->

    </div><!-- /.container -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/ekko-lightbox-js-path.php'; ?>

    <script>

    var options = {
        always_show_close: false
    };

    $( document ).ready(function() {
        var video_selector;
        video_selector = $('#video-selector').html();

        if (video_selector === 'full-video') {
            $('#video-full-video').ekkoLightbox(options);
        } else if (video_selector === 'sign-in') {
            $('#video-sign-in').ekkoLightbox(options);
        } else if (video_selector === 'register') {
            $('#video-register').ekkoLightbox(options);
        } else if (video_selector === 'forgotten-password') {
            $('#video-forgotten-password').ekkoLightbox(options);
        } else if (video_selector === 'password-reset') {
            $('#video-password-reset').ekkoLightbox(options);
        }
        else if (video_selector === 'timetable') {
            $('#video-timetable').ekkoLightbox(options);
        } else if (video_selector === 'exams') {
            $('#video-exams').ekkoLightbox(options);
        } else if (video_selector === 'results') {
            $('#video-results').ekkoLightbox(options);
        } else if (video_selector === 'transport') {
            $('#video-transport').ekkoLightbox(options);
        } else if (video_selector === 'library') {
            $('#video-library').ekkoLightbox(options);
        } else if (video_selector === 'calendar') {
            $('#video-calendar').ekkoLightbox(options);
        } else if (video_selector === 'university-map') {
            $('#video-university-map').ekkoLightbox(options);
        } else if (video_selector === 'events') {
            $('#video-events').ekkoLightbox(options);
        } else if (video_selector === 'feedback') {
            $('#video-feedback').ekkoLightbox(options);
        } else if (video_selector === 'messenger') {
            $('#video-messenger').ekkoLightbox(options);
        } else if (video_selector === 'account') {
            $('#video-account').ekkoLightbox(options);
        }
    });


    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox(options);
    });
    </script>

</body>
</html>
