<?php

namespace engine\classes;

use engine\Debug;

class WebApplication
{
    public static function create(QueryParser $parser)
    {
        try {
            $controllerRef = new \ReflectionClass($parser->controller);
            $actionMethod = $controllerRef->getMethod($parser->action);
            $actionMethod->invoke(new $parser->controller);
        } catch (\Exception $e) {
            Debug::pre($e->getTraceAsString());
        }
    }
}