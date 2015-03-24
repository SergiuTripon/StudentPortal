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
foreach($res as $row) {

if ($row->task_class === 'event-info') {
    $pretitle = 'Book:';
} else {
    $pretitle = 'Task:';
}

    $taskid = $row->taskid;
    $task_name = $pretitle . '' . $row->task_name;
    $task_url = $row->task_url;
    $task_class = $row->taskid;
    $task_startdate = $row->task_startdate;
    $task_duedate = $row->task_duedate;

    $out[] = array(
        'id'    => $taskid,
        'title' => $task_name,
        'url'   => $task_url,
        'class' => $task_class,
        'start' => strtotime($task_startdate) . '000',
        'end'   => strtotime($task_duedate) .'000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;
