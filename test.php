<?php
include 'includes/session.php';
include 'includes/functions.php';

$isUpdate = '0';

calendarUpdate1($isUpdate);

function calendarUpdate1($isUpdate) {
    if ($isUpdate = 1) {
        echo 'Parameter is 1';
    } else {
        echo 'Parameter is 0';
    }
}