<?php
include '../../session.php';

header("Cache-Control: no-cache, must-revalidate");

$sql = 'SELECT t.taskid, t.task_name, t.task_class, t.task_startdate, t.task_duedate
FROM user_task t
JOIN user_detail d ON t.userid = d.userid
WHERE t.userid = "'.$session_userid.'" AND t.task_status = "active"

UNION ALL

SELECT b.bookid, b.book_name, l.book_class, l.created_on, l.toreturn_on
FROM system_book_loaned l
JOIN system_book b ON l.bookid = b.bookid
JOIN user_detail d ON l.userid = d.userid
WHERE l.userid = "'.$session_userid.'" AND l.isReturned="active" AND l.loan_status = "active" AND b.book_status = "active"';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

$out = array();
foreach($res as $row) 
{
  $out[] = array(
    'id'    => $row->taskid,
    'title' => $row->task_name,
    'url'   => $row->task_url,
	'class' => $row->task_class,
    'start' => strtotime($row->task_startdate) . '000',
    'end'   => strtotime($row->task_duedate) .'000'
   );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;
