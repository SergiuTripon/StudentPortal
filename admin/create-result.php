<?php
include '../includes/session.php';

if (isset($_GET['userid'], $_GET['moduleid'])) {

    $result_userid = $_GET['userid'];
    $result_moduleid = $_GET['moduleid'];

    $stmt1 = $mysqli->prepare("SELECT user_signin.email, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid=user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $result_userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($student_email, $student_firstname, $student_surname);
    $stmt1->fetch();

    $stmt2 = $mysqli->prepare("SELECT module_name FROM system_module WHERE moduleid=?");
    $stmt2->bind_param('i', $result_moduleid);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($module_name);
    $stmt2->fetch();

} else {
    header('Location: ../../results/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Create book</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../results/">Results</a></li>
    <li class="active">Create result</li>
    </ol>

    <!-- Create book -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createresults_form" id="createresults_form" novalidate>

    <input type="hidden" name="result_userid" id="result_userid" value="<?php echo $result_userid; ?>">
    <input type="hidden" name="result_moduleid" id="result_moduleid" value="<?php echo $result_moduleid; ?>">

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <h4 class="title-separator text-center">Module</h4>
    <hr class="hr-separator">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0" style="margin-bottom: 20px;">
	<label>Name</label>
    <input class="form-control" type="text" name="module_name" id="module_name" value="<?php echo $module_name; ?>" readonly="readonly">
	</div>
	</div>

    <h4 class="title-separator text-center">Student</h4>
    <hr class="hr-separator">

    <div class="form-group">
    <div class="col-xs-4 col-sm-4 full-width pl0" style="margin-bottom: 20px;">
    <label>First name</label>
    <input class="form-control" type="text" name="student_firstname" id="student_firstname" value="<?php echo $student_firstname; ?>" readonly="readonly">
	</div>
    <div class="col-xs-4 col-sm-4 full-width" style="margin-bottom: 20px;">
    <label>Surname</label>
    <input class="form-control" type="text" name="student_surname" id="student_surname" value="<?php echo $student_surname; ?>" readonly="readonly">
    </div>
    <div class="col-xs-4 col-sm-4 full-width pr0" style="margin-bottom: 20px;">
    <label>Email address</label>
    <input class="form-control" type="email" name="student_email" id="student_email" value="<?php echo $student_email; ?>" readonly="readonly">
	</div>
    </div>

    <h4 class="title-separator text-center">Result</h4>
    <hr class="hr-separator">

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Overall coursework mark (if any)</label>
    <input class="form-control" type="text" name="result_coursework_mark" id="result_coursework_mark" placeholder="Enter a mark">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Overall exam mark (if any)</label>
    <input class="form-control" type="text" name="result_exam_mark" id="result_exam_mark" placeholder="Enter a mark">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Overall final mark</label>
    <input class="form-control" type="text" name="result_overall_mark" id="result_overall_mark" placeholder="Enter a mark">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="result_notes" id="result_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create result</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
	<a class="btn btn-success btn-lg ladda-button" data-style="slide-up" href=""><span class="ladda-label">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create book -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-sad text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/overview/"><span class="ladda-label">Overview</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="../../assets/js/custom/sign-out-inactive.js"></script>

    <?php endif; ?>
	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

    var result_userid = $("#result_userid").val();
    var result_moduleid = $("#result_moduleid").val();
    var result_coursework_mark = $("#result_coursework_mark").val();
    var result_exam_mark = $("#result_exam_mark").val();
    var result_overall_mark = $("#result_overall_mark").val();
    var result_notes = $("#result_notes").val();

    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'result_userid='           + result_userid +
         '&result_moduleid='        + result_moduleid +
         '&result_coursework_mark=' + result_coursework_mark +
         '&result_exam_mark='       + result_exam_mark +
         '&result_overall_mark='    + result_overall_mark +
         '&result_notes='           + result_notes,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Result created successfully.');
		$("#success-button").show();
	},
    error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
	return true;
	});
	</script>

</body>
</html>
