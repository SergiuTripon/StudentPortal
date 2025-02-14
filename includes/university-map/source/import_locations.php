<?php
include '../../../includes/session.php';

ImportLocations();

//ImportLocations function
function ImportLocations () {

    global $mysqli;
    global $marker_category;
    global $created_on;
    global $marker_status;

    $marker_status = 'active';

    //Erase table
    $stmt1 = $mysqli->prepare("DELETE FROM system_map_marker");
    $stmt1->execute();
    $stmt1->close();

    //Get XML contents
    $url1 = 'https://student-portal.co.uk/includes/university-map/xml/locations.xml';
    $result1 = file_get_contents($url1);
    $universitymap_locations = new SimpleXMLElement($result1);

    //Get XML contents
    $url2 = 'https://student-portal.co.uk/includes/university-map/xml/cycle_hire.xml';
    $result2 = file_get_contents($url2);
    $universitymap_cycle_hire = new SimpleXMLElement($result2);

    //Get XML contents
    $url3 = 'https://student-portal.co.uk/includes/university-map/xml/cycle_parking.xml';
    $result3 = file_get_contents($url3);
    $universitymap_cycle_parking = new SimpleXMLElement($result3);

    //Get XML contents
    $url4 = 'https://student-portal.co.uk/includes/university-map/xml/atms.xml';
    $result4 = file_get_contents($url4);
    $universitymap_atms = new SimpleXMLElement($result4);

    //Locations

    //For each, get attributes between XML tags, and insert into database
    foreach ($universitymap_locations->channel->item as $xml_var) {

        $marker_name = $xml_var->title;
        $marker_url = $xml_var->link;
        $maker_notes = $xml_var->description;

        $namespaces = $xml_var->getNameSpaces(true);
        $latlong_selector = $xml_var->children($namespaces['geo']);

        $marker_lat = $latlong_selector->lat;
        $marker_long = $latlong_selector->long;

        $marker_category = $xml_var->category;

        $stmt2 = $mysqli->prepare("INSERT INTO system_map_marker (marker_name, marker_notes, marker_url, marker_lat, marker_long, marker_category, marker_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param('ssssssss', $marker_name, $maker_notes, $marker_url, $marker_lat, $marker_long, $marker_category, $marker_status, $created_on);
        $stmt2->execute();
        $stmt2->close();
    }

    //Cycle Hire

    //For each, get attributes between XML tags, and insert into database
    foreach ($universitymap_cycle_hire->Document->Placemark as $xml_var) {

        $marker_title = $xml_var->name;
        $maker_notes = $xml_var->description;
        $latlong = $xml_var->Point->coordinates;

        list($marker_lat, $marker_long) = explode(',', $latlong);

        $marker_category = 'cycle hire';

        $stmt3 = $mysqli->prepare("INSERT INTO system_map_marker (marker_name, marker_notes, marker_lat, marker_long, marker_category, marker_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssssss', $marker_title, $maker_notes, $marker_long, $marker_lat, $marker_category, $marker_status, $created_on);
        $stmt3->execute();
        $stmt3->close();
    }

    //Cycle Parking

    //For each, get attributes between XML tags, and insert into database
    foreach ($universitymap_cycle_parking->Document->Placemark as $xml_var) {

        $marker_title = $xml_var->name;
        $maker_notes = $xml_var->description;
        $latlong = $xml_var->Point->coordinates;

        list($marker_lat, $marker_long) = explode(',', $latlong);

        $marker_category = 'cycle parking';

        $stmt3 = $mysqli->prepare("INSERT INTO system_map_marker (marker_name, marker_notes, marker_lat, marker_long, marker_category, marker_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssssss', $marker_title, $maker_notes, $marker_long, $marker_lat, $marker_category, $marker_status, $created_on);
        $stmt3->execute();
        $stmt3->close();
    }

    //ATMs

    //For each, get attributes between XML tags, and insert into database
    foreach ($universitymap_atms->Document->Folder->Placemark as $xml_var) {

        $marker_title = $xml_var->name;
        $maker_notes = $xml_var->description;
        $latlong = $xml_var->Point->coordinates;

        list($marker_lat, $marker_long) = explode(',', $latlong);

        $marker_category = 'atm';

        $stmt3 = $mysqli->prepare("INSERT INTO system_map_marker (marker_name, marker_notes, marker_lat, marker_long, marker_category, marker_status, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param('sssssss', $marker_title, $maker_notes, $marker_long, $marker_lat, $marker_category, $marker_status, $created_on);
        $stmt3->execute();
        $stmt3->close();
    }

}
