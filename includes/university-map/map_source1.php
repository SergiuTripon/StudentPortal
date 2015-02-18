<?php

require '../session.php';

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Search the rows in the markers table
$stmt1 = $mysqli->query("SELECT marker_title, marker_lat, marker_lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( marker_lat ) ) * cos( radians( marker_lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM system_map_markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
    mysql_real_escape_string($center_lat),
    mysql_real_escape_string($center_lng),
    mysql_real_escape_string($center_lat),
    mysql_real_escape_string($radius));

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = $mysqli->fetch_assoc()){
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $row['marker_title']);
    $newnode->setAttribute("lat", $row['marker_lat']);
    $newnode->setAttribute("lng", $row['marker_long']);
    $newnode->setAttribute("distance", $row['distance']);
}

echo $dom->saveXML();