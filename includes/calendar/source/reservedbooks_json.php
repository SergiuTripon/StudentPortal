<?php
include '../../session.php';

header("Cache-Control: no-cache, must-revalidate");

$sql = 'SELECT reserved_books.bookid, reserved_books.book_class, reserved_books.reserved_on, reserved_books.toreturn_on, system_books.book_name FROM reserved_books LEFT JOIN system_books ON reserved_books.bookid=system_books.bookid WHERE reserved_books.userid = "'.$session_userid.'" AND reserved_books.isReturned = "0" AND system_books.book_status = "reserved"';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

$out = array();
foreach($res as $row)
{
    $out[] = array(
        'id'    => $row->bookid,
        'title' => $row->book_name,
        'class' => $row->book_class,
        'start' => strtotime($row->reserved_on) . '000',
        'end'   => strtotime($row->toreturn_on) .'000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;
