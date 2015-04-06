<?php
include 'includes/session.php';
include 'includes/functions.php';

AdminTimetableUpdate($isUpdate = 1, $userid = 4);

echo $inactive_result;