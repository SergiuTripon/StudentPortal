<?php
include 'session.php';

header("Cache-Control: no-cache, must-revalidate");

$sql = 'SELECT lectureid, lecture_name FROM system_lectures WHERE moduleid = 1 ';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

$out = array();
foreach($res as $row)
{
  $out[] = array(
    'id'    => $row->lectureid,
    'title' => $row->lecture_name
   );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;