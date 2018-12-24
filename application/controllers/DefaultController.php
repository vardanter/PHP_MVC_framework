<?php

namespace application\controllers;

use engine\Application;
use engine\classes\Controller;
use engine\Debug;

class DefaultController extends Controller
{
    public function locals()
    {
        $config = Application::instance()->getConfig();
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $config->lang;
        $localPath = realpath('') . '/' . $config->locals . '/' . $lang;
        $messages = [];

        $localFiles = scandir($localPath);

        foreach ($localFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $fileName = basename($file, '.php');
            $filePath = $localPath . '/' . $file;
            $messages[$fileName] = require ($filePath);
        }
        header("Content-type: application/json");
        echo ";window.translate = " . json_encode(['messages' => $messages]);
        die();
    }

    public function setLanguage()
    {
        $lang = $_GET['lang'];
        $url = $_SERVER['HTTP_REFERER'];
        if (!empty($lang) && ($lang == 'ru' || $lang == 'en')) {
            $_SESSION['lang'] = $lang;
        }

        header("Location: {$url}");
    }
}