<?php
include '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Create module</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Create module</li>
    </ol>

    <!-- Create module -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="createmodule_form" id="createmodule_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="module_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="module_name" id="module_name" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Moodle URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" placeholder="Enter a URL">
	</div>
	</div>

    <hr>

	</div>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg btn-load">Create module</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none;">
    <hr class="hr-success">
    <a class="btn btn-primary btn-lg btn-load" href="">Create another</span></a>
	</div>
	
    </form>
    <!-- End of Create module -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Create module process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

    //Validation and data gathering
	var hasError = false;

	var module_name = $("#module_name").val();
	if(module_name === '') {
        $("label[for='module_name']").empty().append("Please enter a module name.");
        $("label[for='module_name']").removeClass("feedback-success");
        $("label[for='module_name']").addClass("feedback-danger");
        $("#module_name").removeClass("input-success");
        $("#module_name").addClass("input-danger");
        $("#module_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='module_name']").empty().append("All good!");
        $("label[for='module_name']").removeClass("feedback-danger");
        $("label[for='module_name']").addClass("feedback-success");
        $("#module_name").removeClass("input-danger");
        $("#module_name").addClass("input-success");
	}

    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

    //Ajax
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'create_module_name='    + module_name +
         '&create_module_notes='  + module_notes +
         '&create_module_url='    + module_url,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('All done! The module has been created.');
		$("#success-button").show();
	},
    error:function (xhr, ajaxOptions, thrownError){
		buttonReset();
        $("#success").hide();
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }
	return true;
	});
	</script>

    <?php else : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
	<p class="feedback-danger text-center">You need to have an admin account to access this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/home/">Home</span></a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

    <?php endif; ?>
	<?php else : ?>

	<?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-danger text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg btn-load" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>
    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<?php endif; ?>

</body>
</html>
