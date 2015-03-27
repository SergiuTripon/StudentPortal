<?php
$date  = '01/07/1993';
$date = DateTime::createFromFormat('d/m/Y', $date);
$date = $date->format('Y-m-d');
echo $date;
