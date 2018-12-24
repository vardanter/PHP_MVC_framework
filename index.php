<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
require_once ('./engine/autoload.php');

use engine\Application;

$config = require './application/config/main.php';

try {
    Application::instance()->createApplication($config);
} catch (Exception $e) {
    echo $e->getTraceAsString();die;
}
