<?php
include '../includes/session.php';

UpdateTransportStatus();
//InsertTransportStatus();

//GetTransportStatus function
function UpdateTransportStatus () {

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

        $tube_line = $xml_var->Line->attributes()->Name;
        $tube_line_status = $xml_var->Status->attributes()->Description;
        $tube_line_info = $xml_var->attributes()->StatusDetails;

        $stmt1 = $mysqli->prepare("UPDATE tube_line_status_now SET tube_line=?, tube_line_status=?, tube_line_info=?, updated_on=? WHERE tube_line=?");
        $stmt1->bind_param('sssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on, $tube_line);
        $stmt1->execute();
        $stmt1->close();
    }

    //Live Station status
    foreach ($xml_station_status->StationStatus as $xml_var) {

        $tube_station = $xml_var->Station->attributes()->Name;
        $tube_station_status = $xml_var->Status->attributes()->Description;
        $tube_station_info = $xml_var->attributes()->StatusDetails;

        $stmt1 = $mysqli->prepare("UPDATE tube_station_status_now SET tube_station=?, tube_station_status=?, tube_station_info=?, updated_on=?");
        $stmt1->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //This Weekend Line status
    foreach ($xml_this_weekend->Lines->Line as $xml_var) {

        $tube_line = $xml_var->Name;
        $tube_line_status = $xml_var->Status->Text;
        $tube_line_info = $xml_var->Status->Message->Text;

        $stmt1 = $mysqli->prepare("UPDATE tube_line_status_this_weekend SET tube_line=?, tube_line_status=?, tube_line_info=?, updated_on=?");
        $stmt1->bind_param('ssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //This Weekend Station status
    foreach ($xml_this_weekend->Stations->Station as $xml_var) {

        $tube_station = $xml_var->Name;
        $tube_station_status = $xml_var->Status->Text;
        $tube_station_info = $xml_var->Status->Message->Text;

        $stmt1 = $mysqli->prepare("UPDATE tube_station_status_this_weekend SET tube_station=?, tube_station_status=?, tube_station_info=?, updated_on=?");
        $stmt1->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //Cycle hire
    foreach ($cycle_hire->station as $xml_var) {

        $dock_name = $xml_var->name;
        $dock_installed = $xml_var->installed;
        $dock_locked = $xml_var->locked;
        $dock_temporary = $xml_var->temporary;
        $dock_bikes_available = $xml_var->nbBikes;
        $dock_empty_docks = $xml_var->nbEmptyDocks;
        $dock_total_docks = $xml_var->nbDocks;

        $stmt1 = $mysqli->prepare("UPDATE INTO cycle_hire_status_now SET dock_name=?, dock_installed=?, dock_locked=?, dock_temporary=?, dock_bikes_available=?, dock_empty_docks=?, dock_total_docks=?, updated_on=?)");
        $stmt1->bind_param('ssssiiis', $dock_name, $dock_installed, $dock_locked, $dock_temporary, $dock_bikes_available, $dock_empty_docks, $dock_total_docks, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }
}

//GetTransportStatus function
function InsertTransportStatus () {

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

        $tube_line = $xml_var->Line->attributes()->Name;
        $tube_line_status = $xml_var->Status->attributes()->Description;
        $tube_line_info = $xml_var->attributes()->StatusDetails;

        $stmt1 = $mysqli->prepare("INSERT INTO tube_line_status_now (tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param('ssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //Live Station status
    foreach ($xml_station_status->StationStatus as $xml_var) {

        $tube_station = $xml_var->Station->attributes()->Name;
        $tube_station_status = $xml_var->Status->attributes()->Description;
        $tube_station_info = $xml_var->attributes()->StatusDetails;

        $stmt1 = $mysqli->prepare("INSERT INTO tube_station_status_now (tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //This Weekend Line status
    foreach ($xml_this_weekend->Lines->Line as $xml_var) {

        $tube_line = $xml_var->Name;
        $tube_line_status = $xml_var->Status->Text;
        $tube_line_info = $xml_var->Status->Message->Text;

        $stmt1 = $mysqli->prepare("INSERT INTO tube_line_status_this_weekend (tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param('ssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //This Weekend Station status
    foreach ($xml_this_weekend->Stations->Station as $xml_var) {

        $tube_station = $xml_var->Name;
        $tube_station_status = $xml_var->Status->Text;
        $tube_station_info = $xml_var->Status->Message->Text;

        $stmt1 = $mysqli->prepare("INSERT INTO tube_station_status_this_weekend (tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }

    //Cycle hire
    foreach ($cycle_hire->station as $xml_var) {

        $dock_name = $xml_var->name;
        $dock_installed = $xml_var->installed;
        $dock_locked = $xml_var->locked;
        $dock_temporary = $xml_var->temporary;
        $dock_bikes_available = $xml_var->nbBikes;
        $dock_empty_docks = $xml_var->nbEmptyDocks;
        $dock_total_docks = $xml_var->nbDocks;

        $stmt1 = $mysqli->prepare("INSERT INTO cycle_hire_status_now (dock_name, dock_installed, dock_locked, dock_temporary, dock_bikes_available, dock_empty_docks, dock_total_docks, updated_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param('ssssiiis', $dock_name, $dock_installed, $dock_locked, $dock_temporary, $dock_bikes_available, $dock_empty_docks, $dock_total_docks, $updated_on);
        $stmt1->execute();
        $stmt1->close();
    }
}