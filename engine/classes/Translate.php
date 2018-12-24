<?php

namespace engine\classes;

use engine\Application;

class Translate
{
    protected static $data;

    public static function t($template, $key, array $params = [])
    {
        if (static::$data === null || !isset(static::$data[$template])) {
            static::$data[$template] = self::getData($template);
        }

        return !empty(self::$data[$template][$key]) ? vsprintf(self::$data[$template][$key], $params) : $key;
    }

    protected static function getData($template)
    {
        $localsPath = realpath('') . '/' . Application::instance()->getConfig()->locals;
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : Application::instance()->getConfig()->lang;
        return require_once ($localsPath . '/' . $lang . '/' . $template . '.php');
    }

}