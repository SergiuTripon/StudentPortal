<?php
include '../includes/session.php';

DeleteTransportStatus();
GetTransportStatus();

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
            $stmt2->bind_param('isssss', $tube_lineid, $tube_line, $tube_line_status, $tube_line_info, $updated_on, $tube_lineid);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        } else {
            $stmt2 = $mysqli->prepare("INSERT INTO tube_line_status_now (tube_lineid, tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param('issss', $tube_lineid, $tube_line, $tube_line_status, $tube_line_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        }
    }

    //Live Station status
    foreach ($xml_station_status->StationStatus as $xml_var) {

        $tube_station = $xml_var->Station->attributes()->Name;
        $tube_station_status = $xml_var->Status->attributes()->Description;
        $tube_station_info = $xml_var->attributes()->StatusDetails;

        $stmt1 = $mysqli->prepare("SELECT tube_station from tube_station_status_now WHERE tube_station = ?");
        $stmt1->bind_param('s', $tube_station);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_tube_station);
        $stmt1->fetch();

        if ($stmt1->num_rows == 1) {
            $stmt2 = $mysqli->prepare("UPDATE tube_station_status_now SET tube_station=?, tube_station_status=?, tube_station_info=?, updated_on=? WHERE tube_station=?");
            $stmt2->bind_param('sssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on, $tube_station);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        } else {
            $stmt2 = $mysqli->prepare("INSERT INTO tube_station_status_now (tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        }
    }

    //This Weekend Line status
    foreach ($xml_this_weekend->Lines->Line as $xml_var) {

        $tube_line = $xml_var->Name;
        $tube_line_status = $xml_var->Status->Text;
        $tube_line_info = $xml_var->Status->Message->Text;

        $stmt1 = $mysqli->prepare("SELECT tube_line from tube_line_status_this_weekend WHERE tube_line = ?");
        $stmt1->bind_param('s', $tube_line);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_tube_line);
        $stmt1->fetch();

        if ($stmt1->num_rows == 1) {
            $stmt2 = $mysqli->prepare("UPDATE tube_line_status_this_weekend SET tube_line=?, tube_line_status=?, tube_line_info=?, updated_on=? WHERE tube_line=?");
            $stmt2->bind_param('sssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on, $tube_line);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        } else {
            $stmt2 = $mysqli->prepare("INSERT INTO tube_line_status_this_weekend (tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param('ssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        }
    }

    //This Weekend Station status
    foreach ($xml_this_weekend->Stations->Station as $xml_var) {

        $tube_station = $xml_var->Name;
        $tube_station_status = $xml_var->Status->Text;
        $tube_station_info = $xml_var->Status->Message->Text;

        $stmt1 = $mysqli->prepare("SELECT tube_station from tube_station_status_this_weekend WHERE tube_station = ? AND tube_station_info=?");
        $stmt1->bind_param('ss', $tube_station, $tube_station_info);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_tube_station);
        $stmt1->fetch();

        if ($stmt1->num_rows == 1) {
            $stmt2 = $mysqli->prepare("UPDATE tube_station_status_this_weekend SET tube_station=?, tube_station_status=?, tube_station_info=?, updated_on=? WHERE tube_station=?");
            $stmt2->bind_param('sssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on, $tube_station);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        } else {
            $stmt2 = $mysqli->prepare("INSERT INTO tube_station_status_this_weekend (tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        }
    }

    //Cycle hire
    foreach ($cycle_hire->station as $xml_var) {

        $dockid = $xml_var->id;
        $dock_name = $xml_var->name;
        $dock_installed = $xml_var->installed;
        $dock_locked = $xml_var->locked;
        $dock_temporary = $xml_var->temporary;
        $dock_bikes_available = $xml_var->nbBikes;
        $dock_empty_docks = $xml_var->nbEmptyDocks;
        $dock_total_docks = $xml_var->nbDocks;

        $stmt1 = $mysqli->prepare("SELECT dockid from cycle_hire_status_now WHERE dockid = ?");
        $stmt1->bind_param('i', $dockid);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($db_dockid);
        $stmt1->fetch();

        if ($stmt1->num_rows == 1) {
            $stmt2 = $mysqli->prepare("UPDATE cycle_hire_status_now SET dock_name=?, dock_installed=?, dock_locked=?, dock_temporary=?, dock_bikes_available=?, dock_empty_docks=?, dock_total_docks=?, updated_on=? WHERE dock_name=?");
            $stmt2->bind_param('issssiiiss', $dockid, $dock_name, $dock_installed, $dock_locked, $dock_temporary, $dock_bikes_available, $dock_empty_docks, $dock_total_docks, $updated_on, $dock_name);
            $stmt2->execute();
            $stmt2->close();

            $stmt1->close();
        } else {
            $stmt2 = $mysqli->prepare("INSERT INTO cycle_hire_status_now (dockid, dock_name, dock_installed, dock_locked, dock_temporary, dock_bikes_available, dock_empty_docks, dock_total_docks, updated_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param('issssiiis', $dockid, $dock_name, $dock_installed, $dock_locked, $dock_temporary, $dock_bikes_available, $dock_empty_docks, $dock_total_docks, $updated_on);
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