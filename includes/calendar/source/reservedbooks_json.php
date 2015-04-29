<?php
include '../../session.php';

header("Cache-Control: no-cache, must-revalidate");

//Getting active books reserved by the currently signed in user
$sql = 'SELECT l.bookid, l.book_class, l.created_on, l.toreturn_on, b.book_name FROM system_book_loaned l LEFT JOIN system_book b ON l.bookid=b.bookid WHERE l.userid = "'.$session_userid.'" AND l.isReturned = "0" AND b.book_status = "active"';

$res = $pdo->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);

//Creating an array
$out = array();

//Binding results to array
foreach($res as $row)
{
    $out[] = array(
        'id'    => $row->bookid,
        'title' => $row->book_name,
        'class' => $row->book_class,
        'start' => strtotime($row->created_on) . '000',
        'end'   => strtotime($row->toreturn_on) .'000'
    );
}

//Converting array into JSON and showing it
echo json_encode(array('success' => 1, 'result' => $out));
exit;
