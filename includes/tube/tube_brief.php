<?php

date_default_timezone_set('Europe/London');
$time = date('H:i');

$url = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
$result = file_get_contents($url);
$xml = new SimpleXMLElement($result);

$bakerloo = $xml->LineStatus[0]->Line->attributes()->Name;
$bakerloo1 = $xml->LineStatus[0]->Status->attributes()->Description;

$central = $xml->LineStatus[1]->Line->attributes()->Name;
$central1 = $xml->LineStatus[1]->Status->attributes()->Description;

$circle = $xml->LineStatus[2]->Line->attributes()->Name;
$circle1 = $xml->LineStatus[2]->Status->attributes()->Description;

$district = $xml->LineStatus[3]->Line->attributes()->Name;
$district1 = $xml->LineStatus[3]->Status->attributes()->Description;

$hammersmith = $xml->LineStatus[4]->Line->attributes()->Name;
$hammersmith1 = $xml->LineStatus[4]->Status->attributes()->Description;

$jubilee = $xml->LineStatus[5]->Line->attributes()->Name;
$jubilee1 = $xml->LineStatus[5]->Status->attributes()->Description;

$metropolitan = $xml->LineStatus[6]->Line->attributes()->Name;
$metropolitan1 = $xml->LineStatus[6]->Status->attributes()->Description;

$northern = $xml->LineStatus[7]->Line->attributes()->Name;
$northern1 = $xml->LineStatus[7]->Status->attributes()->Description;

$picadilly = $xml->LineStatus[8]->Line->attributes()->Name;
$picadilly1 = $xml->LineStatus[8]->Status->attributes()->Description;

$victoria = $xml->LineStatus[9]->Line->attributes()->Name;
$victoria1 = $xml->LineStatus[9]->Status->attributes()->Description;

$waterloo = $xml->LineStatus[10]->Line->attributes()->Name;
$waterloo1 = $xml->LineStatus[10]->Status->attributes()->Description;

$overground = $xml->LineStatus[11]->Line->attributes()->Name;
$overground1 = $xml->LineStatus[11]->Status->attributes()->Description;

$dlr = $xml->LineStatus[12]->Line->attributes()->Name;
$dlr1 = $xml->LineStatus[12]->Status->attributes()->Description;

?>
