<?php
include '../includes/session.php';

if (isset($_GET['id'])) {

    $moduleToUpdate = $_GET['id'];

    $stmt1 = $mysqli->prepare("SELECT m.moduleid, m.module_name, m.module_notes, m.module_url FROM system_modules m WHERE m.moduleid = ? LIMIT 1");
    $stmt1->bind_param('i', $moduleToUpdate);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($moduleid, $module_name, $module_notes, $module_url);
    $stmt1->fetch();
    $stmt1->close();

} else {
    header('Location: ../../timetable/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <?php include '../assets/css-paths/select2-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>

    <title>Student Portal | Update module</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../timetable/">Timetable</a></li>
    <li class="active">Update module</li>
    </ol>

    <!-- Update module -->
	<form class="form-custom" style="max-width: 100%;" name="updatetimetable_form" id="updatetimetable_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <input type="hidden" name="moduleid" id="moduleid" value="<?php echo $moduleid; ?>">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label for="module_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="module_name" id="module_name" value="<?php echo $module_name; ?>" placeholder="Enter a name">
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Notes</label>
    <textarea class="form-control" rows="5" name="module_notes" id="module_notes" placeholder="Enter notes"><?php echo $module_notes; ?></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Moodle URL</label>
    <input class="form-control" type="text" name="module_url" id="module_url" value="<?php echo $module_url; ?>" placeholder="Enter a moodle URL">
	</div>
	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Update module</span></button>
    </div>

    </div>
	
    </form>
    <!-- End of Update module -->
	</div>
    <!-- /container -->
	
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
    <?php include '../assets/js-paths/select2-js-path.php'; ?>
	<?php include '../assets/js-paths/datetimepicker-js-path.php'; ?>

	<script>

	//Ladda
	Ladda.bind('.ladda-button', {timeout: 2000});

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;

    //Modules
    var moduleid = $("#moduleid").val();

	var module_name = $("#module_name").val();
	if(module_name === '') {
        $("label[for='module_name']").empty().append("Please enter a module name.");
        $("label[for='module_name']").removeClass("feedback-happy");
        $("label[for='module_name']").addClass("feedback-sad");
        $("#module_name").removeClass("input-happy");
        $("#module_name").addClass("input-sad");
        $("#module_name").focus();
		hasError  = true;
		return false;
    } else {
        $("label[for='module_name']").empty().append("All good!");
        $("label[for='module_name']").removeClass("feedback-sad");
        $("label[for='module_name']").addClass("feedback-happy");
        $("#module_name").removeClass("input-sad");
        $("#module_name").addClass("input-happy");
	}

    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'update_moduleid=' + moduleid +
         '&update_module_name='   + module_name +
         '&update_module_notes='  + module_notes +
         '&update_module_url='    + module_url,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").show();
		$("#success").empty().append('Module updated successfully.');
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
	</script>

</body>
</html>
