<?php

require '../../session.php';

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Search the rows in the markers table
$query = sprintf("SELECT marker_title, marker_description, marker_lat, marker_long, marker_category, (3959 * acos(cos(radians('%s')) * cos(radians(marker_lat)) * cos(radians(marker_long) - radians('%s')) + sin( radians('%s') ) * sin(radians(marker_lat)))) AS distance FROM system_map_markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
    $mysqli->real_escape_string($center_lat),
    $mysqli->real_escape_string($center_lng),
    $mysqli->real_escape_string($center_lat),
    $mysqli->real_escape_string($radius));
$result = $mysqli->query($query);

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = $result->fetch_assoc()){
      $node = $dom->createElement("marker");
      $newnode = $parnode->appendChild($node);
      $newnode->setAttribute("name", $row['marker_name']);
      $newnode->setAttribute("notes", $row['marker_notes']);
      $newnode->setAttribute("lat", $row['marker_lat']);
      $newnode->setAttribute("lng", $row['marker_long']);
      $newnode->setAttribute("category", $row['marker_category']);
      $newnode->setAttribute("distance", $row['distance']);
    }

echo $dom->saveXML();
