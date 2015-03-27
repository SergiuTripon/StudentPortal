<?php
$date  = '27/03/2015 19:39';
$date = DateTime::createFromFormat('d/m/Y H:i', $date);
$date = $date->format('Y-m-d H:i');
echo $date;
