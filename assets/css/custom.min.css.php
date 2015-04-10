<?php
header('Content-type: text/css');
ob_start("compress");

function compress($minify)
{
    /* remove comments */
    $minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify);

    /* remove tabs, spaces, newlines, etc. */
    $minify = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $minify);

    return $minify;
}

/* css files for combining */
include('bootstrap/bootstrap.min.css');
include('calendar/calendar.min.css');
include('custom/custom.css');
include('data-tables/dataTables.bootstrap.css');
include('data-tables/dataTables.fontAwesome.css');
include('date-time-picker/bootstrap-datetimepicker.min.css');
include('ekko-lightbox/ekko-lightbox.min.css');
include('font-awesome/font-awesome.min.css');
include('select2/select2.min.css');

ob_end_flush();