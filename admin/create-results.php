<?php
include '../includes/session.php';

if (isset($_GET['userid'], $_GET['moduleid'])) {

    $userid = $_GET['userid'];
    $moduleid = $_GET['moduleid'];

    $stmt1 = $mysqli->prepare("SELECT user_signin.email, user_details.firstname, user_details.surname FROM user_signin LEFT JOIN user_details ON user_signin.userid=user_details.userid WHERE user_signin.userid = ? LIMIT 1");
    $stmt1->bind_param('i', $userid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($student_email, $student_firstname, $student_surname);
    $stmt1->fetch();

    $stmt2 = $mysqli->prepare("SELECT moduleid, module_name FROM system_modules WHERE system_modules.moduleid=?");
    $stmt2->bind_param('i', $moduleid);
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
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="results-portal" class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Create results</li>
    </ol>

    <!-- Create book -->
	<form class="form-custom" style="max-width: 100%;" name="createresults_form" id="createresults_form" novalidate>

    <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
    <input type="hidden" name="moduleid" id="moduleid" value="<?php echo $moduleid; ?>">

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <h4 class="text-center">Module</h4>
    <hr class="hr-custom">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Name</label>
    <input class="form-control" type="text" name="module_name" id="module_name" value="<?php echo $module_name; ?>" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book author</label>
    <input class="form-control" type="text" name="book_author" id="book_author" placeholder="Enter an author">
	</div>
	</div>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book notes</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book copy number</label>
    <input class="form-control" type="text" name="book_copy_no" id="book_copy_no" placeholder="Enter a copy number">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create book</span></button>
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

    <form class="form-custom">

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
	
    <form class="form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg ladda-button" data-style="slide-up" href="/"><span class="ladda-label">Sign In</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
	$(document).ready(function () {

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
	var book_name = $("#book_name").val();
	if(book_name === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a name.");
		$("#book_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#book_name").addClass("success-style");
	}

    var book_author = $("#book_author").val();
	if(book_author === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter an author.");
		$("#book_author").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#book_author").addClass("success-style");
	}

    var book_notes = $("#book_notes").val();

    var book_copy_no = $("#book_copy_no").val();
	if(book_copy_no === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a copy number.");
		$("#book_copy_no").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#book_copy_no").addClass("success-style");
	}

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'book_name='     + book_name +
         '&book_author='  + book_author +
         '&book_notes='   + book_notes +
         '&book_copy_no=' + book_copy_no,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Book created successfully.');
		$("#success-button").show();
	},
    error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }

	return true;

	});
	});
	</script>

</body>
</html>
