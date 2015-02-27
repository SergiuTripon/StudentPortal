<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Features</title>

    <style>
    #features {
        background-color: #735326;
    }
    #features a {
        color: #FFFFFF;
    }
    #features a:focus, #features a:hover {
        color: #FFFFFF;
    }
    </style>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

     <?php include 'includes/menus/portal_menu.php'; ?>

    <div id="features-showcase" class="container"><!-- container -->

    <h1 class="text-center">Features</h1>
    <hr class="hr-small">

	<p class="text-left">Click and discover</p>

    <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="timetable">
	<div class="tile large-tile">
    <i class="fa fa-clock-o"></i>
	<p>Timetable</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="exams">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Exams</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div id="library">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p>Library</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="transport">
	<div class="tile">
    <i class="fa fa-bus"></i>
	<p>Transport</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="calendar1">
	<div class="tile">
	<i class="fa fa-calendar"></i>
	<p>Calendar</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="events">
	<div class="tile">
	<i class="fa fa-ticket"></i>
	<p>Events</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="university-map">
	<div class="tile">
    <i class="fa fa-map-marker"></i>
	<p>University Map</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="feedback">
	<div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p>Feedback</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="messenger">
	<div class="tile">
    <i class="fa fa-comments"></i>
	<p>Messenger</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div id="account">
	<div class="tile">
    <i class="fa fa-user"></i>
	<p>Account</p>
	</div>
	</div>
	</div>
	</div><!-- /.row -->

    </div><!-- /.container -->

    <!-- Feature Modal -->
    <div class="modal fade modal-custom" id="modal-features" tabindex="-1" role="dialog" aria-labelledby="-modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header">
    <div class="close"></div>
    <h4 class="modal-title" id="modal-custom-label"></h4>
    </div>

    <div class="modal-body">
    </div>

	<div class="modal-footer">
	<div class="text-center">
    <button type="button" class="btn btn-danger btn-lg" data-style="slide-up" data-dismiss="modal">Close</button>
	</div>
	</div>

	</div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->
	<!-- End of Feature Modal -->

    <?php include 'includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../assets/js/sign-out-inactive.js"></script>

	<?php else : ?>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="features-showcase" class="container"><!-- container -->

    <h1 class="text-center">Features</h1>
    <hr class="hr-small">

	<p class="text-left">Click and discover</p>

    <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="timetable">
	<div class="tile large-tile">
    <i class="fa fa-clock-o"></i>
	<p>Timetable</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="exams">
	<div class="tile">
	<i class="fa fa-pencil"></i>
	<p>Exams</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
	<div id="library">
	<div class="tile">
    <i class="fa fa-book"></i>
	<p>Library</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="transport">
	<div class="tile">
    <i class="fa fa-bus"></i>
	<p>Transport</p>
    </div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="calendar1">
	<div class="tile">
	<i class="fa fa-calendar"></i>
	<p>Calendar</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div id="events">
	<div class="tile">
	<i class="fa fa-ticket"></i>
	<p>Events</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="university-map">
	<div class="tile">
    <i class="fa fa-map-marker"></i>
	<p>University Map</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-3 col-md-4 col-lg-4">
    <div id="feedback">
	<div class="tile">
    <i class="fa fa-check-square-o"></i>
	<p>Feedback</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
    <div id="messenger">
	<div class="tile">
    <i class="fa fa-comments"></i>
	<p>Messenger</p>
	</div>
	</div>
	</div>

    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
	<div id="account">
	<div class="tile">
    <i class="fa fa-user"></i>
	<p>Account</p>
	</div>
	</div>
	</div>
	</div><!-- /.row -->

    </div><!-- /.container -->

    <!-- Feature Modal -->
    <div class="modal fade modal-custom" id="modal-features" tabindex="-1" role="dialog" aria-labelledby="-modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header">
    <div class="close"></div>
    <h4 class="modal-title" id="modal-custom-label"></h4>
    </div>

    <div class="modal-body">
    </div>

	<div class="modal-footer">
	<div class="text-center">
    <button type="button" class="btn btn-danger btn-lg" data-style="slide-up" data-dismiss="modal">Close</button>
	</div>
	</div>

	</div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->
	<!-- End of Feature Modal -->

    <?php include 'includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>
    <?php include 'assets/js-paths/easing-js-path.php'; ?>

	<script>
    $(document).ready(function() {

    $( "#timetable" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Timetable");
        $('.close').empty().append("<i class=\"fa fa-table\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">No one likes 9am lectures, especially when hungover from the night before. An easily accessible timetable will help you organise yourself better as you roll out of bed in the morning‏.</p>");
    });
    $( "#exams" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Exams");
        $('.close').empty().append("<i class=\"fa fa-pencil\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">The word that every student hates. But this feature will make your life a little less stressful by helping you get to your exams on time and get the best results. Revision's all on you though.</p>");
    });
    $( "#library" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Library");
        $('.close').empty().append("<i class=\"fa fa-book\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Feeling like a couch potato and don't want to go to the library? No sweat, just log on, have a browse and reserve what you fancy, or renew something that you already have on loan‏.</p>");
    });
    $( "#transport" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Transport");
        $('.close').empty().append("<i class=\"fa fa-subway\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">So you get to the tube station and your line is delayed. We've all been there. Now you can check transport updates from our web app without the hassle of going on the TfL website‏.</p>");
    });
    $( "#calendar1" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Calendar");
        $('.close').empty().append("<i class=\"fa fa-calendar\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Your own personal secretary who sits in your back pocket. They'll nag you about what you need to do and when.</p>");
    });
    $( "#events" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Events");
        $('.close').empty().append("<i class=\"fa fa-beer\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Let's be honest. We all say at the beginning of the year that we'll go to events but we never do. Here's your chance to get involved and have some fun. It's in your hands‏.</p>");
    });
    $( "#university-map" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("University Map");
        $('.close').empty().append("<i class=\"fa fa-map-marker\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">That moment of panic when you have to go to a new classroom that you've never heard of. Admit it, it's not just freshers who get lost. But fear not, with the web app you'll have your own portable TomTom&#8482;‏.</p>");
    });
    $( "#feedback" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Feedback");
        $('.close').empty().append("<i class=\"fa fa-check-square-o\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">Everyone dreads their lecturer handing them the paper-based Student Survey. Let's not kill anymore trees. Just keep calm and log on to provide your feedback. Your lecturer will even be able to contact you in person to discuss any concerns.</p>");
    });
    $( "#messenger" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Messenger");
        $('.close').empty().append("<i class=\"fa fa-comments\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">So your lecturers office is on the fourth floor and there's no lift. Why bother climbing the stairs or opening your email when you can just send them a quick message? Simples.</p>");
    });
    $( "#account" ).click(function() {
        $('#modal-features').modal('show');
        $('#modal-custom-label').empty().append("Account");
        $('.close').empty().append("<i class=\"fa fa-user\"></i>");
        $('.modal-body').empty().append("<p class=\"feedback-custom text-justify\">There are some things in life you can't control, but you can have full control of your account right here. See what it feels like to be the boss.</p>");
    });

    });
    </script>

</body>
</html>
