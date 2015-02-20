<?php

require '../session.php';

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Select all the rows in the markers table

$stmt1 = $mysqli->query("SELECT * FROM system_map_markers WHERE 1");

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = $stmt1->fetch_assoc()){
    // ADD TO XML DOCUMENT NODE
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name",$row['marker_title']);
    $newnode->setAttribute("description", $row['marker_description']);
    $newnode->setAttribute("lat", $row['marker_lat']);
    $newnode->setAttribute("lng", $row['marker_long']);
    $newnode->setAttribute("icon", $row['marker_icon']);
    $newnode->setAttribute("type", $row['marker_category']);
}

echo $dom->saveXML();
