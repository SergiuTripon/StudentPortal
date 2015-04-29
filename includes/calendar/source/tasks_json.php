<?php
include '../../session.php';

header("Cache-Control: no-cache, must-revalidate");

//Getting active tasks, books reserved and booked events belonging to the currently signed in user
$sql = 'SELECT t.taskid, t.task_name, t.task_class, t.task_startdate, t.task_duedate
FROM user_task t
WHERE t.userid = "'.$session_userid.'" AND t.task_status = "active"

UNION ALL

SELECT b.bookid, b.book_name, l.book_class, l.created_on, l.toreturn_on
FROM system_book_loaned l
JOIN system_book b ON l.bookid = b.bookid
WHERE l.userid = "'.$session_userid.'" AND l.isReturned="0" AND l.loan_status = "ongoing" AND b.book_status = "active"

UNION ALL

SELECT e.eventid, e.event_name, b.event_class, e.event_from, e.event_to
FROM system_event_booked b
JOIN system_event e ON b.eventid = e.eventid
WHERE b.userid = "'.$session_userid.'" AND e.event_status = "active" AND DATE(e.event_to) > DATE(NOW())';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

//Creating an array
$out = array();

//Binding results to array
foreach($res as $row) {

//If task_class is "event-info", do the following
if ($row->task_class === 'event-info') {
    $pretitle = 'Task: ';
}

//If task_class is "event-important", do the following
if ($row->task_class === 'event-important') {
    $pretitle = 'Event: ';
}

//If task_class is "event-success", do the following
if ($row->task_class === 'event-success') {
    $pretitle = 'Book: ';
}

    $taskid = $row->taskid;
    $task_name = $pretitle . $row->task_name;
    $task_url = $row->task_url;
    $task_class = $row->task_class;
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

//Converting array into JSON and showing it
echo json_encode(array('success' => 1, 'result' => $out));
exit;
