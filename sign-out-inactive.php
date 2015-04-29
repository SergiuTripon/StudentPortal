<?php
include 'includes/session.php';

//Unset session
session_unset();

//Destroy session
session_destroy();

//Redirect to locked-out page
header('Location: locked-out');

