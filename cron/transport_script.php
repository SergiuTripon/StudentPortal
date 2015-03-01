<?php
include '../includes/session.php';

GetLiveTubeStatus();

//GetLiveTubeStatus function
function GetLiveTubeStatus () {

    global $mysqli;
    global $updated_on;
    global $xml_line_status;
    global $xml_station_status;

    $url1 = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
    $result1 = file_get_contents($url1);
    $xml_line_status = new SimpleXMLElement($result1);

    $url2 = 'http://cloud.tfl.gov.uk/TrackerNet/StationStatus';
    $result2 = file_get_contents($url2);
    $xml_station_status = new SimpleXMLElement($result2);

    //Line status
    foreach ($xml_line_status->LineStatus as $xml_var) {

    $tube_line = $xml_var->Line->attributes()->Name;
    $tube_line_status = $xml_var->Status->attributes()->Description;
    $tube_line_info = $xml_var->attributes()->StatusDetails;

    $stmt1 = $mysqli->prepare("INSERT INTO tube_line_status_now (tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param('ssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on);
    $stmt1->execute();
    $stmt1->close();
    }

    //Station status
    foreach ($xml_station_status->StationStatus as $xml_var) {

    $tube_station = $xml_var->Station->attributes()->Name;
    $tube_station_status = $xml_var->Status->attributes()->Description;
    $tube_station_info = $xml_var->attributes()->StatusDetails;

    $stmt1 = $mysqli->prepare("INSERT INTO tube_station_status_now (tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
    $stmt1->execute();
    $stmt1->close();
    }
}