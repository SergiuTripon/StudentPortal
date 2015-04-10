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
include('bootstrap.min.css');
include('calendar.min.css');
include('dataTables.bootstrap.css');
include('dataTables.fontAwesome.css');
include('bootstrap-datetimepicker.min.css');
include('ekko-lightbox.min.css');
include('font-awesome.min.css');
include('select2.min.css');
include('custom.css');

ob_end_flush();