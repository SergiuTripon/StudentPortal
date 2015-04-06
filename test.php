<?php
include 'includes/session.php';
include 'includes/functions.php';

AdminTimetableUpdate($isIpdate = 1, $userid = '3');

echo $array['active_result'];
echo $array['inactive_result'];