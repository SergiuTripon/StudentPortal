<?php
$date  = '27/03/2015';
$date = date("Y-m-d H:i",strtotime("$date"));
//$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1', $date);
//$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $date);
echo $date;
