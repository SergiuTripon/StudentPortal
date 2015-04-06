<?php
include 'includes/session.php';
include 'includes/functions.php';

AdminTimetableUpdate($userid = '3');

echo $active_result;
echo $inactive_result;