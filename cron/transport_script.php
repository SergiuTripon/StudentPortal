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

    date_default_timezone_set('Europe/London');
    $updated_on = date("Y-m-d G:i:s");

    //Live Line status
	$tube_line_status_now_url = 'http://cloud.tfl.gov.uk/TrackerNet/LineStatus';
	$tube_line_status_now_result = file_get_contents($tube_line_status_now_url);

    if ($tube_line_status_now_result === FALSE) {

        $cron_job = 'transport_script.txt';
        $cron_log = fopen("cron_log.txt", "w") or exit("Unable to open file!");
        $cron_log_content = "$cron_job failed to run on $updated_on.". PHP_EOL ."";
        fwrite($cron_log, $cron_log_content);
        fclose($cron_log);
        exit();

    } else {

        $xml_line_status_now = new SimpleXMLElement($tube_line_status_now_result);

        foreach ($xml_line_status_now->LineStatus as $xml_var) {

            $tube_lineid = $xml_var->Line->attributes()->ID;
            $tube_line = $xml_var->Line->attributes()->Name;
            $tube_line_status = $xml_var->Status->attributes()->Description;
            $tube_line_info = $xml_var->attributes()->StatusDetails;

            $stmt1 = $mysqli->prepare("DELETE FROM tube_line_status_now");
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $mysqli->prepare("INSERT INTO tube_line_status_now (tube_lineid, tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param('issss', $tube_lineid, $tube_line, $tube_line_status, $tube_line_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();
        }

    }

    //Live Station status
    $tube_station_status_now_ulr = 'http://cloud.tfl.gov.uk/TrackerNet/StationStatus';
    $tube_station_status_result = file_get_contents($tube_station_status_now_ulr);

    if ($tube_station_status_result === FALSE) {

        $cron_job = 'transport_script.txt';
        $cron_log = fopen("cron_log.txt", "w") or die("Unable to open file!");
        $cron_log_content = "$cron_job failed to run on $updated_on.". PHP_EOL ."";
        fwrite($cron_log, $cron_log_content);
        fclose($cron_log);
        exit();

    } else {

        $xml_station_status_now = new SimpleXMLElement($tube_station_status_result);

        foreach ($xml_station_status_now->StationStatus as $xml_var) {

            $tube_stationid = $xml_var->Station->attributes()->ID;
            $tube_station = $xml_var->Station->attributes()->Name;
            $tube_station_status = $xml_var->Status->attributes()->Description;
            $tube_station_info = $xml_var->attributes()->StatusDetails;

            $stmt1 = $mysqli->prepare("DELETE FROM tube_station_status_now");
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $mysqli->prepare("INSERT INTO tube_station_status_now (tube_stationid, tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param('issss', $tube_stationid, $tube_station, $tube_station_status, $tube_station_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();
        }

    }

    //This Weekend Line status
    $tube_line_status_this_weekend_url = 'http://data.tfl.gov.uk/tfl/syndication/feeds/TubeThisWeekend_v2.xml?app_id=16a31ffc&app_key=fc61665981806c124b4a7c939539bf78';
    $tube_line_status_this_weekend_result = file_get_contents($tube_line_status_this_weekend_url);

    if ($tube_line_status_this_weekend_result === FALSE) {

        $cron_job = 'transport_script.txt';
        $cron_log = fopen("cron_log.txt", "w") or die("Unable to open file!");
        $cron_log_content = "$cron_job failed to run on $updated_on.". PHP_EOL ."";
        fwrite($cron_log, $cron_log_content);
        fclose($cron_log);
        exit();

    } else {

        $tube_line_status_this_weekend = new SimpleXMLElement($tube_line_status_this_weekend_result);

        foreach ($tube_line_status_this_weekend->Lines->Line as $xml_var) {

            $tube_line = $xml_var->Name;
            $tube_line_status = $xml_var->Status->Text;
            $tube_line_info = $xml_var->Status->Message->Text;

            $stmt1 = $mysqli->prepare("DELETE FROM tube_line_status_this_weekend");
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $mysqli->prepare("INSERT INTO tube_line_status_this_weekend (tube_line, tube_line_status, tube_line_info, updated_on) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param('ssss', $tube_line, $tube_line_status, $tube_line_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();
        }

        //This Weekend Station status
        foreach ($xml_this_weekend->Stations->Station as $xml_var) {

            $tube_station = $xml_var->Name;
            $tube_station_status = $xml_var->Status->Text;
            $tube_station_info = $xml_var->Status->Message->Text;

            $stmt1 = $mysqli->prepare("DELETE FROM tube_station_status_this_weekend");
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $mysqli->prepare("INSERT INTO tube_station_status_this_weekend (tube_station, tube_station_status, tube_station_info, updated_on) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param('ssss', $tube_station, $tube_station_status, $tube_station_info, $updated_on);
            $stmt2->execute();
            $stmt2->close();
        }

    }

    //Cycle hire
    $cycle_hire_status_now_url = 'http://www.tfl.gov.uk/tfl/syndication/feeds/cycle-hire/livecyclehireupdates.xml';
    $cycle_hire_status_now_result = file_get_contents($cycle_hire_status_now_url);

    if ($cycle_hire_status_now_result === FALSE) {

        $cron_job = 'transport_script.txt';
        $cron_log = fopen("cron_log.txt", "w") or die("Unable to open file!");
        $cron_log_content = "$cron_job failed to run on $updated_on.". PHP_EOL ."";
        fwrite($cron_log, $cron_log_content);
        fclose($cron_log);
        exit();

    } else {

        $cycle_hire_hire_status_now = new SimpleXMLElement($cycle_hire_status_now_result);

        foreach ($cycle_hire_hire_status_now->station as $xml_var) {

            $dockid = $xml_var->id;
            $dock_name = $xml_var->name;
            $dock_installed = $xml_var->installed;
            $dock_locked = $xml_var->locked;
            $dock_temporary = $xml_var->temporary;
            $dock_bikes_available = $xml_var->nbBikes;
            $dock_empty_docks = $xml_var->nbEmptyDocks;
            $dock_total_docks = $xml_var->nbDocks;

            $stmt1 = $mysqli->prepare("DELETE FROM cycle_hire_status_now");
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $mysqli->prepare("INSERT INTO cycle_hire_status_now (dockid, dock_name, dock_installed, dock_locked, dock_temporary, dock_bikes_available, dock_empty_docks, dock_total_docks, updated_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param('issssiiis', $dockid, $dock_name, $dock_installed, $dock_locked, $dock_temporary, $dock_bikes_available, $dock_empty_docks, $dock_total_docks, $updated_on);
            $stmt2->execute();
            $stmt2->close();
        }
    }

    $cron_job = 'transport_script.txt';

    $cron_log = fopen("cron_log.txt", "a") or die("Unable to open file!");
    $cron_log_content = "$cron_job ran successfully at $updated_on.". PHP_EOL ."";
    fwrite($cron_log, $cron_log_content);
    fclose($cron_log);

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