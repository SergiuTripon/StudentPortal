<?php
include '../includes/db_connection.php';

GetTransportStatus();
//DeleteTransportStatus();

//GetTransportStatus function
function GetTransportStatus () {

    global $mysqli;
    global $updated_on;
	global $xml_line_status;
	global $xml_station_status;
    global $xml_this_weekend;
    global $cycle_hire;

	$url1 = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
	$result1 = file_get_contents($url1);
	$xml_line_status = new SimpleXMLElement($result1);

    $url2 = 'http://cloud.tfl.gov.uk/TrackerNet/StationStatus';
    $result2 = file_get_contents($url2);
    $xml_station_status = new SimpleXMLElement($result2);

    $url3 = 'http://data.tfl.gov.uk/tfl/syndication/feeds/TubeThisWeekend_v2.xml?app_id=16a31ffc&app_key=fc61665981806c124b4a7c939539bf78';
    $result3 = file_get_contents($url3);
    $xml_this_weekend = new SimpleXMLElement($result3);

    $url4 = 'http://www.tfl.gov.uk/tfl/syndication/feeds/cycle-hire/livecyclehireupdates.xml';
    $result4 = file_get_contents($url4);
    $cycle_hire = new SimpleXMLElement($result4);

    //Live Line status
    foreach ($xml_line_status->LineStatus as $xml_var) {

        $tube_lineid = $xml_var->Line->attributes()->ID;
        $tube_line = $xml_var->Line->attributes()->Name;
        $tube_line_status = $xml_var->Status->attributes()->Description;
        $tube_line_info = $xml_var->attributes()->StatusDetails;

        $stmt1 = $mysqli->prepare("SELECT tube_lineid FROM tube_line_status_now WHERE tube_lineid = ?");
        $stmt1->bind_param('i', $tube_lineid);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_tube_lineid);
        $stmt1->fetch();

        if ($stmt1->num_rows == 1) {
            $stmt2 = $mysqli->prepare("UPDATE tube_line_status_now SET tube_lineid=?, tube_line=?, tube_line_status=?, tube_line_info=?, updated_on=? WHERE tube_lineid=?");
            $stmt2->bind_param('issssi', $tube_lineid, $tube_line, $tube_line_status, $tube_line_info, $updated_on, $tube_lineid);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        } else {
            $stmt2 = $mysqli->prepare("INSERT INTO tube_line_status_now (tube_stationid, tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param('issss', $tube_lineid, $tube_line, $tube_line_status, $tube_line_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        }
    }
}

//GetTransportStatus function
function DeleteTransportStatus () {

    global $mysqli;

    $stmt1 = $mysqli->prepare("DELETE FROM tube_line_status_now");
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("DELETE FROM tube_station_status_now");
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $mysqli->prepare("DELETE FROM tube_line_status_this_weekend");
    $stmt3->execute();
    $stmt3->close();

    $stmt4 = $mysqli->prepare("DELETE FROM tube_station_status_this_weekend");
    $stmt4->execute();
    $stmt4->close();

    $stmt5 = $mysqli->prepare("DELETE FROM cycle_hire_status_now");
    $stmt5->execute();
    $stmt5->close();
}