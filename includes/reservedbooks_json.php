<?php
include 'session.php';

header("Cache-Control: no-cache, must-revalidate");

$sql = 'SELECT reserved_books.bookid, reserved_books.reserved_on, system_books.toreturn_on,  system_books.book_name FROM reserved_books LEFT JOIN system_books ON reserved_books.bookid=system_books.bookid WHERE reserved_books.userid = "'.$userid.'" AND reserved_books.isReturned = "0" AND system_books.book_status = "active"';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

$out = array();
foreach($res as $row)
{
    $out[] = array(
        'id'    => $row->taskid,
        'title' => $row->book_name,
        'url'   => $row->book_author,
        'class' => $row->task_class,
        'start' => strtotime($row->task_startdate) . '000',
        'end'   => strtotime($row->task_duedate) .'000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;