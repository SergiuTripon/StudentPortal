<?php
include '../includes/session.php';

if (isset($_GET["id"])) {

$taskToUpdate = $_GET["id"];

$stmt1 = $mysqli->prepare("SELECT taskid, task_name, task_notes, task_url, DATE_FORMAT(task_startdate,'%Y-%m-%d %H:%i') as task_startdate, DATE_FORMAT(task_duedate,'%Y-%m-%d %H:%i') as task_duedate FROM user_task WHERE taskid = ? LIMIT 1");
$stmt1->bind_param('i', $taskToUpdate);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($taskid, $task_name, $task_notes, $task_url, $task_startdate, $task_duedate);
$stmt1->fetch();
$stmt1->close();

} else {
header('Location: ../calendar/');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Update task</title>

    <?php include '../assets/css-paths/select2-css-path.php'; ?>
    <?php include '../assets/css-paths/common-css-paths.php'; ?>
    <?php include '../assets/css-paths/datetimepicker-css-path.php'; ?>
	
</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../calendar/">Calendar</a></li>
    <li class="active">Update task</li>
    </ol>
	
	<!-- Update a task -->
    
	<form class="form-custom" style="max-width: 100%;" name="updatetask_form" id="updatetask_form">
	
    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<input type="hidden" name="taskid" id="taskid" value="<?php echo $taskid; ?>" />
	
    <label for="task_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="task_name" id="task_name" value="<?php echo $task_name; ?>" placeholder="Enter a name">

    <label>Notes (Optional)</label>
    <textarea class="form-control" rows="5" name="task_notes" id="task_notes" placeholder="Notes"><?php echo $task_notes; ?></textarea>

	<label>External URL (www.example.com)</label>
	<input class="form-control" type="text" name="task_url" id="task_url" value="<?php echo $task_url; ?>" placeholder="Enter an external URL">

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width pl0">
	<label for="task_startdate">Start date and time<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="task_startdate" id="task_startdate" value="<?php echo $task_startdate; ?>" placeholder="Select a start date and time"/>
	</div>
	<div class="col-xs-6 col-sm-6 full-width pr0">
	<label for="task_duedate">Due date and time<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="task_duedate" id="task_duedate"  value="<?php echo $task_duedate; ?>" placeholder="Select a due date and time"/>
	</div>
	</div>

	<hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button mt10" data-style="slide-up"><span class="ladda-label">Update task</span></button>
    </div>

	</div>
	
    </form>
            
	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <!-- Sign Out (Inactive) JS -->
    <script src="https://student-portal.co.uk/assets/js/custom/sign-out-inactive.js"></script>

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

	//Date Time Picker
    $('#task_startdate').datetimepicker({
        format: 'YYYY/MM/DD HH:mm'
    });
    $('#task_duedate').datetimepicker({
        format: 'YYYY/MM/DD HH:mm'
    });

	//Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	var taskid = $("#taskid").val();

	var task_name = $("#task_name").val();
	if(task_name === '') {
        $("label[for='task_name']").empty().append("Please enter a name.");
        $("label[for='task_name']").removeClass("feedback-happy");
        $("#task_name").removeClass("input-happy");
        $("label[for='task_name']").addClass("feedback-sad");
        $("#task_name").addClass("input-sad");
        $("#task_name").focus();
        hasError = true;
        return false;
    } else {
        $("label[for='task_name']").empty().append("All good!");
        $("label[for='task_name']").removeClass("feedback-sad");
        $("#task_name").removeClass("input-sad");
        $("label[for='task_name']").addClass("feedback-happy");
        $("#task_name").addClass("input-happy");
	}

	var task_notes = $("#task_notes").val();
	var task_url = $("#task_url").val();

	var task_startdate = $("#task_startdate").val();
	if(task_startdate === '') {
        $("label[for='task_startdate']").empty().append("Please select a date and time.");
        $("label[for='task_startdate']").removeClass("feedback-happy");
        $("#task_startdate").removeClass("input-happy");
        $("label[for='task_startdate']").addClass("feedback-sad");
        $("#task_startdate").addClass("input-sad");
        $("#task_startdate").focus();
        hasError = true;
        return false;
	} else {
        $("label[for='task_startdate']").empty().append("All good!");
        $("label[for='task_startdate']").removeClass("feedback-sad");
        $("#task_startdate").removeClass("input-sad");
        $("label[for='task_startdate']").addClass("feedback-happy");
        $("#task_startdate").addClass("input-happy");
	}

	var task_duedate = $("#task_duedate").val();
	if(task_duedate === '') {
        $("label[for='task_duedate']").empty().append("Please select a date and time.");
        $("label[for='task_duedate']").removeClass("feedback-happy");
        $("#task_duedate").removeClass("input-happy");
        $("label[for='task_duedate']").addClass("feedback-sad");
        $("#task_duedate").addClass("input-sad");
        $("#task_duedate").focus();
        hasError = true;
        return false;
    } else {
        $("label[for='task_duedate']").empty().append("All good!");
        $("label[for='task_duedate']").removeClass("feedback-sad");
        $("#task_duedate").removeClass("input-sad");
        $("label[for='task_duedate']").addClass("feedback-happy");
        $("#task_duedate").addClass("input-happy");
	}
	
	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'update_taskid=' + taskid +
         '&update_task_name=' + task_name +
         '&update_task_notes=' + task_notes +
         '&update_task_url=' + task_url +
         '&update_task_startdate=' + task_startdate +
         '&update_task_duedate=' + task_duedate,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").empty().append('Task updated successfully.');
		$('#updatetask_form').trigger("reset");
    },
    error:function (xhr, ajaxOptions, thrownError){
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
