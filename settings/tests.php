<?php



ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($str)
{
    echo '<pre>';
    print_r($str);
    echo '</pre>';
    exit;
}

function see($str)
{
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}

function dumpMe($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
}

function ifStr($str, $action){
    if(isset($str) && !empty($str)){
        return $action;
    }
}