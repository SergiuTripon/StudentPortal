<?php
include 'includes/session.php';
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

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/ekko-lightbox-js-path.php'; ?>

    <script>
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            always_show_close: false
        });
    });
    </script>

</body>
</html>
