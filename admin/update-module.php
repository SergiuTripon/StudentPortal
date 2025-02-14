<?php
include '../includes/session.php';

//If URL parameter is set, do the following
if (isset($_GET['id'])) {

    $moduleToUpdate = $_GET['id'];

    $stmt1 = $mysqli->prepare("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url FROM system_module m WHERE m.moduleid = ? LIMIT 1");
    $stmt1->bind_param('i', $moduleToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $module_name, $module_notes, $module_url);
    $stmt1->fetch();
    $stmt1->close();

//If URL parameter is not set, do the following
} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Update module</title>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'administrator') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Update module</li>
    </ol>

    <!-- Update module -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updatetimetable_form" id="updatetimetable_form" novalidate>

    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

    <input type="hidden" name="moduleid" id="moduleid" value="<?php echo $moduleid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label for="module_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="module_name" id="module_name" value="<?php echo $module_name; ?>" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter notes"><?php echo $module_notes; ?></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width">
	<label>Moodle URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" value="<?php echo $module_url; ?>" placeholder="Enter a moodle URL">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Update module</button>
    </div>

    </div>
	
    </form>
    <!-- End of Update module -->
	</div>
    <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

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
    <a class="btn btn-primary btn-lg" href="/home/">Home</a>
    </div>

    </form>
    
	</div>

	<?php include '../includes/footers/footer.php'; ?>

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
    <a class="btn btn-primary btn-lg" href="/">Sign in</a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

    //Update module process
    $("#FormSubmit").click(function (e) {
    e.preventDefault();

	var hasError = false;

    var moduleid = $("#moduleid").val();

    //Checking if module_name is inputted
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

	if(hasError == false){
    jQuery.ajax({
	type: "POST",

    //URL to POST data to
	url: "https://student-portal.co.uk/includes/processes.php",

    //Data posted
    data:'update_moduleid='      + moduleid +
         '&update_module_name='  + module_name +
         '&update_module_notes=' + module_notes +
         '&update_module_url='   + module_url,

    //If action completed, do the following
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('All done! The module has been updated.');
	},

    //If action failed, do the following
    error:function (xhr, ajaxOptions, thrownError){
		$("#success").hide();
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }
	return true;
	});
	</script>

</body>
</html>
