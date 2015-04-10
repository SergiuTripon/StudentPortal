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
include('custom.css');

ob_end_flush();