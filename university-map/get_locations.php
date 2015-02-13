<?php
include '../includes/session.php';

GetUniversityMapLocations();

//GetLiveTubeStatus function
function GetUniversityMapLocations () {

	global $mysqli;

	$stmt1 = $mysqli->prepare("DELETE FROM system_map_markers");
	$stmt1->execute();
	$stmt1->close();

	$url = 'locations.xml';
	$result = file_get_contents($url);
	$universitymap_locations = new SimpleXMLElement($result);

	foreach ($universitymap_locations->channel->item as $xml_var) {

	$title = $xml_var->title;
	$description = $xml_var->description;
	$link = $xml_var->link;

	$namespaces = $xml_var->getNameSpaces(true);
	$latlong_selector = $xml_var->children($namespaces['geo']);
	$icon_selector = $xml_var->children($namespaces['CUL']);

	$lat = $latlong_selector->lat;
	$long = $latlong_selector->long;
	$icon = $icon_selector->icon;

	$category = $xml_var->category;

	$stmt2 = $mysqli->prepare("INSERT INTO system_map_markers (marker_title, marker_description, marker_link, marker_lat, marker_long, marker_icon, marker_category) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt2->bind_param('sssssss', $title, $description, $link, $lat, $long, $icon, $category);
	$stmt2->execute();
	$stmt2->close();
	}

}
