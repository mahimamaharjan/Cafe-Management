<?php
include_once 'config.php';

$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($db->connect_errno) {
    die('Failed to connect to database.');
}
include_once 'functions.php';
session_start();