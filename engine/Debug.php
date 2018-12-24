<?php

namespace engine;

class Debug
{
    public static function pre($data, $die = true)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if ($die) {
            die();
        }
    }

    public static function logToFile($data, $filePath = null)
    {
        if ($filePath === null) {
            $filePath = realpath('') . '/application/log/log.txt';
        }

        ob_start();
        echo '-----Start log at ' . date('Y-m-d H:i:s') . '------' . "\n";
        print_r($data);
        echo '-----End log-----' ."\n\n";
        $log = ob_get_clean();

        $logFile = fopen($filePath, 'a+');
        fwrite($logFile, $log);
        fclose($logFile);
    }
}