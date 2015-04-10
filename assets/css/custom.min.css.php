<?php
header('Content-type: text/css');
ob_start("compress");

function compress($minify) {

    /* remove comments */
    $minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify);

    /* remove tabs, spaces, newlines, etc. */
    $minify = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $minify);

    return $minify;
}

/* css files for combining */
include('files/bootstrap.min.css');
include('files/calendar.min.css');
include('files/dataTables.bootstrap.css');
include('files/dataTables.fontAwesome.css');
include('files/bootstrap-datetimepicker.min.css');
include('files/ekko-lightbox.min.css');
include('files/font-awesome.min.css');
include('files/select2.min.css');
include('files/custom.css');

ob_end_flush();