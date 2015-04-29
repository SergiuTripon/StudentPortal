<?php
include '../../session.php';

header("Cache-Control: no-cache, must-revalidate");

//Getting active events
$sql = 'SELECT eventid, event_name, event_url, event_class, event_from, event_to FROM system_event WHERE event_status = "active"';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

//Creating an array
$out = array();

//Binding results to array
foreach($res as $row)
{
    $out[] = array(
        'id'    => $row->eventid,
        'title' => $row->event_name,
        'url'   => $row->event_url,
        'class' => $row->event_class,
        'start' => strtotime($row->event_from) . '000',
        'end'   => strtotime($row->event_to) .'000'
    );
}

//Converting array into JSON and showing it
echo json_encode(array('success' => 1, 'result' => $out));
exit;
