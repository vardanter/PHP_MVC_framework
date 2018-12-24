<?php
function autoload($class) {
    $className = realpath('') . '/' . trim(str_replace('\\', '/', $class), '/') . '.php';
    require_once ($className);
}

spl_autoload_register('autoload');