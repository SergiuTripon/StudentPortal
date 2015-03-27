<?php
$date  = '01/07/1993';
$date = date("Y-m-d",strtotime("$date"));
//$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1', $date);
//$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $date);
echo $date;
