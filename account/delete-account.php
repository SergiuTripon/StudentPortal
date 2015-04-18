<?php
include '../includes/session.php';

global $mysqli;

$stmt1 = $mysqli->prepare("SELECT user_signin.email, user_detail.studentno, user_detail.firstname, user_detail.surname FROM user_signin LEFT JOIN user_detail ON user_signin.userid = user_detail.userid WHERE user_signin.userid = ? LIMIT 1");
$stmt1->bind_param('i', $session_userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($email, $studentno, $firstname, $surname);
$stmt1->fetch();

if ($studentno === 0) {
    $studentno = '-';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

    <title>Student Portal | Delete Account</title>

</head>

<body>

    <?php include '../assets/css-paths/common-css-paths.php'; ?>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
    <li><a href="../../home/">Home</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Delete account</li>
    </ol>
	
    <!-- Delete account -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="delete_account_form">

    <div class="form-group">
    
	<div class="col-xs-6 col-sm-6 full-width">
    <label>First name</label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="First name" readonly="readonly">
	<label>Student number</label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" placeholder="Student Number" readonly="readonly">
	</div>

    <div class="col-xs-6 col-sm-6 full-width">
	<label>Surname</label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Surname" readonly="readonly">
    <label>Email address</label>
    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email address" readonly="readonly">
    </div>
    
	</div>

    <hr class="hr-custom">

    <div class="text-center">
    <a class="btn btn-primary btn-lg" data-toggle="modal" href="#delete-account-modal">Delete account</span></a>
    </div>

    </form>

    <!-- Delete Account Modal -->
    <div id="delete-account-modal" class="modal fade modal-custom modal-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-custom-label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
    <div class="close" data-dismiss="modal"><i class="fa fa-times"></i></div>
    <h4 class="modal-title" id="modal-custom-label">Delete account?</h4>
    </div>

    <div class="modal-body">
    <div id="session_userid" style="display: none;"><?php echo $session_userid; ?></div>
    <p class="text-left">Are you sure you want to delete your account?</p>
    </div>

    <div class="modal-footer">
    <div class="text-right">
    <a class="btn btn-primary btn-lg btn-delete-account btn-load">Delete</a>
    <a class="btn btn-default btn-lg" data-dismiss="modal">Cancel</a>
    </div>
    </div>

    </div><!-- /modal -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal-content -->

    </div> <!-- /container -->
	
	<?php include '../includes/footers/footer.php'; ?>

    <?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
    //Ajax call
    $(".btn-delete-account").click(function (e) {
    e.preventDefault();

    var accountToDelete = $("#session_userid").html();

    jQuery.ajax({
    type: "POST",
    url: "https://student-portal.co.uk/includes/processes.php",
    data:'accountToDelete=' + accountToDelete,
    success:function(){

        buttonReset();

        window.location.href = "/account/account-deleted/";
    },
    error:function (xhr, ajaxOptions, thrownError){
        buttonReset();
        $("#error").show();
        $("#error").empty().append(thrownError);
    }
    });
    return true;
    });
    </script>

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
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

</body>
</html>
