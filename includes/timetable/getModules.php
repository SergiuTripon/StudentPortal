<?php
include '../../includes/session.php';
?>



    <script>
    //Ladda
    Ladda.bind('.ladda-button', {timeout: 2000});

    //DataTables
    $('.admin-modules-table').dataTable({
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no timetables to display."
        }
    });

    $("body").on("click", ".assign-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#assign-timetable-form-" + DbNumberID).submit();

	});

    $("body").on("click", ".update-button", function(e) {
    e.preventDefault();

	var clickedID = this.id.split('-');
    var DbNumberID = clickedID[1];

	$("#update-timetable-form-" + DbNumberID).submit();

	});

    $("body").on("click", ".cancel-button", function(e) {
    e.preventDefault();

    var clickedID = this.id.split('-');
    var timetableToCancel = clickedID[1];

	jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
	dataType:"text",
	data:'timetableToCancel='+ timetableToCancel,
	success:function(){
		$('#cancel-'+timetableToCancel).fadeOut();
        $('#admin-cancelled-modules').load('https://student-portal.co.uk/includes/timetable/getCancelledModules.php');
	},

	error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
		$("#error").empty().append(thrownError);
	}

	});

    });
    </script>