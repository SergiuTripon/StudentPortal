<?php
include 'signin.php';

if (isset($_SESSION['userid']))
$userid = $_SESSION['userid'];
else $userid = '';

$db = new PDO('mysql:host=localhost;dbname=student_portal;charset=utf8', 'sergiutripon', 'MJvmJRG4XGdV8Wv');

$sql = 'SELECT taskid, task_name, task_url, task_class, task_startdate, task_duedate FROM user_tasks WHERE userid = "'.$userid.'" AND task_status = "active"';

$res = $db->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

$out = array();
foreach($res as $row) 
{
  $out[] = array(
    'id' => $row->taskid,
    'title' => $row->task_name,
    'url' => $row->task_url,
	'class' => $row->task_class,
    'start' => strtotime($row->task_startdate) . '000',
    'end' => strtotime($row->task_duedate) .'000'
   );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;

?>