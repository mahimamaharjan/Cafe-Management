<?php
session_start();


function autoloader($classname)
{
       $classname = str_replace("\\", "/", trim($classname, "\\"));
       $filename = __DIR__ . '/' . $classname . '.php';
    require_once ($filename);
}

spl_autoload_register('autoloader');
?>
