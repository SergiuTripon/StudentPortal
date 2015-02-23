<?php
include '../includes/session.php';
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

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
	
    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'admin') : ?>

	<?php include '../includes/menus/portal_menu.php'; ?>

	<div id="admin-timetable-portal" class="container">

    <ol class="breadcrumb">
    <li><a href="../../overview/">Overview</a></li>
	<li><a href="../../library/">Library</a></li>
    <li class="active">Create book</li>
    </ol>

    <!-- Create book -->
	<form class="form-custom" style="max-width: 100%;" name="createbook_form" id="createbook_form" novalidate>

    <p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book name</label>
    <input class="form-control" type="text" name="book_name" id="book_name" placeholder="Enter a name">
	</div>
	</div>
	<p id="error1" class="feedback-sad text-center"></p>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book author</label>
    <input class="form-control" type="text" name="book_author" id="book_author" placeholder="Enter an author">
	</div>
	</div>
    <p id="error2" class="feedback-sad text-center"></p>

    <div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book notes</label>
    <textarea class="form-control" rows="5" name="book_notes" id="book_notes" placeholder="Enter notes"></textarea>
	</div>
	</div>

	<div class="form-group">
	<div class="col-xs-12 col-sm-12 full-width pr0 pl0">
	<label>Book copy number</label>
    <input class="form-control" type="text" name="book_copyno" id="book_copyno" placeholder="Enter a copy number">
	</div>
	</div>

	</div>

	<hr>

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg ladda-button" data-style="slide-up"><span class="ladda-label">Create timetable</span></button>
    </div>

	<div id="success-button" class="text-center" style="display:none">
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
	var module_name = $("#module_name").val();
	if(module_name === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a module name.");
		$("#module_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error1").hide();
		$("#module_name").addClass("success-style");
	}

    var module_notes = $("#module_notes").val();
    var module_url = $("#module_url").val();

    //Lectures
	var lecture_name = $("#lecture_name").val();
	if(lecture_name === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter a lecture name.");
		$("#lecture_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error2").hide();
		$("#lecture_name").addClass("success-style");
	}

    var lecturer_check = $("#lecturer option:selected").html();
    if (lecturer_check === 'Select an option') {
        $("#error3").show();
        $("#error3").empty().append("Please select a lecturer.");
        $(".lecturer > .selectpicker").addClass("error-style");
        hasError  = true;
        return false;
    }
    else {
        $("#error3").hide();
        $(".lecturer > .selectpicker").addClass("success-style");
        $(".lecturer > .error-style > .filter-option").css("cssText", "color: #FFFFFF; !important");
    }

    var lecture_day = $("#lecture_day").val();
	if(lecture_day === '') {
		$("#error4").show();
		$("#error4").empty().append("Please enter a day.");
		$("#lecture_day").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error4").hide();
		$("#lecture_day").addClass("success-style");
	}

    var lecture_from_time = $("#lecture_from_time").val();
	if(lecture_from_time === '') {
		$("#error5").show();
		$("#error5").empty().append("Please select a time.");
		$("#lecture_from_time").addClass("error-style");
        hasError  = true;
        return false;
	} else {
		$("#error5").hide();
		$("#lecture_from_time").addClass("success-style");
	}

    var lecture_to_time = $("#lecture_to_time").val();
	if(lecture_to_time === '') {
		$("#error5").show();
		$("#error5").empty().append("Please select a time.");
		$("#lecture_to_time").addClass("error-style");
        hasError  = true;
        return false;
	} else {
		$("#error5").hide();
		$("#lecture_to_time").addClass("success-style");
	}

    var lecture_from_date = $("#lecture_from_date").val();
	if(lecture_from_date === '') {
		$("#error6").show();
		$("#error6").empty().append("Please select a date.");
		$("#lecture_from_date").addClass("error-style");
        hasError  = true;
        return false;
	} else {
		$("#error6").hide();
		$("#lecture_from_date").addClass("success-style");
	}

    var lecture_to_date = $("#lecture_to_date").val();
	if(lecture_to_date === '') {
		$("#error6").show();
		$("#error6").empty().append("Please select a date.");
		$("#lecture_to_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error6").hide();
		$("#lecture_to_date").addClass("success-style");
	}

    var lecture_location = $("#lecture_location").val();
	if(lecture_location === '') {
		$("#error7").show();
		$("#error7").empty().append("Please enter a location.");
		$("#lecture_location").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error7").hide();
		$("#lecture_location").addClass("success-style");
	}

    var lecture_capacity = $("#lecture_capacity").val();
	if(lecture_capacity === '') {
		$("#error7").show();
		$("#error7").empty().append("Please enter a capacity.");
		$("#lecture_capacity").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error7").hide();
		$("#lecture_capacity").addClass("success-style");
	}

    var lecture_lecturer = $("#lecturer option:selected").val();
    var lecture_notes = $("#lecture_notes").val();

    //Tutorials
	var tutorial_name = $("#tutorial_name").val();
	if(tutorial_name === '') {
		$("#error8").show();
        $("#error8").empty().append("Please enter a tutorial name.");
		$("#tutorial_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error8").hide();
		$("#tutorial_name").addClass("success-style");
	}

    var tutorial_assistant_check = $("#tutorial_assistant option:selected").html();
    if (tutorial_assistant_check === 'Select an option') {
        $("#error9").show();
        $("#error9").empty().append("Please select a tutorial assistant.");
        $("#tutorial_assistants").addClass("error-style");
        hasError  = true;
        return false;
    }
    else {
        $("#error9").hide();
        $("#tutorial_assistants").addClass("success-style");
    }

    var tutorial_day = $("#tutorial_day").val();
	if(tutorial_day === '') {
		$("#error10").show();
		$("#error10").empty().append("Please enter a day.");
		$("#tutorial_day").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error10").hide();
		$("#tutorial_day").addClass("success-style");
	}

    var tutorial_from_time = $("#tutorial_from_time").val();
	if(tutorial_from_time === '') {
		$("#error11").show();
		$("#error11").empty().append("Please select a time.");
		$("#tutorial_from_time").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error11").hide();
		$("#tutorial_from_time").addClass("success-style");
	}

    var tutorial_to_time = $("#tutorial_to_time").val();
	if(tutorial_to_time === '') {
		$("#error11").show();
		$("#error11").empty().append("Please select a time.");
		$("#tutorial_to_time").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error11").hide();
		$("#tutorial_to_time").addClass("success-style");
	}

    var tutorial_from_date = $("#tutorial_from_date").val();
	if(tutorial_from_date === '') {
		$("#error12").show();
		$("#error12").empty().append("Please select a time.");
		$("#tutorial_from_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error12").hide();
		$("#tutorial_from_date").addClass("success-style");
	}

    var tutorial_to_date = $("#tutorial_to_date").val();
	if(tutorial_to_date === '') {
		$("#error12").show();
		$("#error12").empty().append("Please select a date.");
		$("#tutorial_to_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error12").hide();
		$("#tutorial_to_date").addClass("success-style");
	}

    var tutorial_location = $("#tutorial_location").val();
	if(tutorial_location === '') {
		$("#error13").show();
		$("#error13").empty().append("Please enter a location.");
		$("#tutorial_location").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error13").hide();
		$("#tutorial_location").addClass("success-style");
	}

    var tutorial_capacity = $("#tutorial_capacity").val();
	if(tutorial_capacity === '') {
		$("#error13").show();
		$("#error13").empty().append("Please enter a capacity.");
		$("#tutorial_capacity").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error13").hide();
		$("#tutorial_capacity").addClass("success-style");
	}

    var tutorial_assistant = $("#tutorial_assistant option:selected").val();
    var tutorial_notes = $("#tutorial_notes").val();

    //Exams
	var exam_name = $("#exam_name").val();
	if(exam_name === '') {
		$("#error14").show();
        $("#error14").empty().append("Please enter a tutorial name.");
		$("#exam_name").addClass("error-style");
		hasError  = true;
		return false;
    } else {
		$("#error14").hide();
		$("#exam_name").addClass("success-style");
	}

    var exam_date = $("#exam_date").val();
	if(exam_date === '') {
		$("#error15").show();
		$("#error15").empty().append("Please select a date.");
		$("#exam_date").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error15").hide();
		$("#exam_date").addClass("success-style");
	}

    var exam_time = $("#exam_time").val();
	if(exam_time === '') {
		$("#error15").show();
		$("#error15").empty().append("Please select a time.");
		$("#exam_time").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error15").hide();
		$("#exam_time").addClass("success-style");
	}

    var exam_location = $("#exam_location").val();
	if(exam_location === '') {
		$("#error16").show();
		$("#error16").empty().append("Please enter a location.");
		$("#exam_location").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error16").hide();
		$("#exam_location").addClass("success-style");
	}

    var exam_capacity = $("#exam_capacity").val();
	if(exam_capacity === '') {
		$("#error16").show();
		$("#error16").empty().append("Please enter a capacity.");
		$("#exam_capacity").addClass("error-style");
		hasError  = true;
        return false;
	} else {
		$("#error16").hide();
		$("#exam_capacity").addClass("success-style");
	}

    var exam_notes = $("#exam_notes").val();

	if(hasError == false){
    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'module_name='         + module_name +
         '&module_notes='       + module_notes +
         '&module_url='         + module_url +
         '&lecture_name='       + lecture_name +
         '&lecture_lecturer='   + lecture_lecturer +
         '&lecture_notes='      + lecture_notes +
         '&lecture_day='        + lecture_day +
         '&lecture_from_time='  + lecture_from_time +
         '&lecture_to_time='    + lecture_to_time +
         '&lecture_from_date='  + lecture_from_date +
         '&lecture_to_date='    + lecture_to_date +
         '&lecture_location='   + lecture_location +
         '&lecture_capacity='   + lecture_capacity +
         '&tutorial_name='      + tutorial_name +
         '&tutorial_assistant=' + tutorial_assistant +
         '&tutorial_notes='     + tutorial_notes +
         '&tutorial_day='       + tutorial_day +
         '&tutorial_from_time=' + tutorial_from_time +
         '&tutorial_to_time='   + tutorial_to_time +
         '&tutorial_from_date=' + tutorial_from_date +
         '&tutorial_to_date='   + tutorial_to_date +
         '&tutorial_location='  + tutorial_location +
         '&tutorial_capacity='  + tutorial_capacity +
         '&exam_name='          + exam_name +
         '&exam_notes='         + exam_notes +
         '&exam_date='          + exam_date +
         '&exam_time='          + exam_time +
         '&exam_location='      + exam_location +
         '&exam_capacity='      + exam_capacity,

    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#FormSubmit").hide();
		$("#success").show();
		$("#success").empty().append('Timetable created successfully.');
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
