<?php
session_start();
function __autoload($class)
{
    //print_r(debug_backtrace());
    include_once('../../Applications/'.str_replace('\\','/',$class) . '.class.php');

}
