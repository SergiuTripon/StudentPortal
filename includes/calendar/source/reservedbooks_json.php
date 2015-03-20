<?php
include '../../session.php';

header("Cache-Control: no-cache, must-revalidate");

$sql = 'SELECT system_books_reserved.bookid, system_books_reserved.book_class, system_books_reserved.reserved_on, system_books_reserved.toreturn_on, system_book.book_name FROM system_books_reserved LEFT JOIN system_book ON system_books_reserved.bookid=system_book.bookid WHERE system_books_reserved.userid = "'.$session_userid.'" AND system_books_reserved.isReturned = "0" AND system_book.book_status = "reserved"';

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
