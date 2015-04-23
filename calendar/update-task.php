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

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

</head>

<body>
	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../calendar/">Calendar</a></li>
    <li class="active">Update task</li>
    </ol>
	
	<!-- Update a task -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updatetask_form" id="updatetask_form">
	
    <p id="error" class="feedback-danger text-center"></p>
	<p id="success" class="feedback-success text-center"></p>

	<div id="hide">

	<input type="hidden" name="taskid" id="taskid" value="<?php echo $taskid; ?>" />

    <label for="task_name">Name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="task_name" id="task_name" value="<?php echo $task_name; ?>" placeholder="Enter a name">

    <label>Notes (Optional)</label>
    <textarea class="form-control" rows="5" name="task_notes" id="task_notes" placeholder="Notes"><?php echo $task_notes; ?></textarea>

	<label>External URL (www.example.com)</label>
	<input class="form-control" type="text" name="task_url" id="task_url" value="<?php echo $task_url; ?>" placeholder="Enter an external URL">

	<div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="task_startdate">Start date and time<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="task_startdate" id="task_startdate" value="<?php echo $task_startdate; ?>" placeholder="Select a start date and time"/>
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="task_duedate">Due date and time<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="task_duedate" id="task_duedate"  value="<?php echo $task_duedate; ?>" placeholder="Select a due date and time"/>
	</div>
	</div>

	<hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg mt10" >Update task</span></button>
    </div>

	</div>
	
    </form>
    <!-- End of Update a task -->

	</div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>




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
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

	<?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>

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
        $("label[for='task_name']").removeClass("feedback-success");
        $("#task_name").removeClass("input-success");
        $("label[for='task_name']").addClass("feedback-danger");
        $("#task_name").addClass("input-danger");
        $("#task_name").focus();
        hasError = true;
        return false;
    } else {
        $("label[for='task_name']").empty().append("All good!");
        $("label[for='task_name']").removeClass("feedback-danger");
        $("#task_name").removeClass("input-danger");
        $("label[for='task_name']").addClass("feedback-success");
        $("#task_name").addClass("input-success");
	}

	var task_notes = $("#task_notes").val();
	var task_url = $("#task_url").val();

	var task_startdate = $("#task_startdate").val();
	if(task_startdate === '') {
        $("label[for='task_startdate']").empty().append("Please select a date and time.");
        $("label[for='task_startdate']").removeClass("feedback-success");
        $("#task_startdate").removeClass("input-success");
        $("label[for='task_startdate']").addClass("feedback-danger");
        $("#task_startdate").addClass("input-danger");
        $("#task_startdate").focus();
        hasError = true;
        return false;
	} else {
        $("label[for='task_startdate']").empty().append("All good!");
        $("label[for='task_startdate']").removeClass("feedback-danger");
        $("#task_startdate").removeClass("input-danger");
        $("label[for='task_startdate']").addClass("feedback-success");
        $("#task_startdate").addClass("input-success");
	}

	var task_duedate = $("#task_duedate").val();
	if(task_duedate === '') {
        $("label[for='task_duedate']").empty().append("Please select a date and time.");
        $("label[for='task_duedate']").removeClass("feedback-success");
        $("#task_duedate").removeClass("input-success");
        $("label[for='task_duedate']").addClass("feedback-danger");
        $("#task_duedate").addClass("input-danger");
        $("#task_duedate").focus();
        hasError = true;
        return false;
    } else {
        $("label[for='task_duedate']").empty().append("All good!");
        $("label[for='task_duedate']").removeClass("feedback-danger");
        $("#task_duedate").removeClass("input-danger");
        $("label[for='task_duedate']").addClass("feedback-success");
        $("#task_duedate").addClass("input-success");
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
