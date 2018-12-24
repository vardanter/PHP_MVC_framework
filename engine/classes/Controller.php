<?php

namespace engine\classes;

class Controller
{
    protected $templateFolder;
    protected $layout = 'main';
    
    public function __construct()
    {
        $className = explode('\\', get_class($this));
        $this->templateFolder = strtolower(str_replace('Controller', '', end($className)));
    }
    
    protected function render($template, $data = [])
    {
        $templatePath = realpath('') . '/application/views/' . $this->templateFolder . '/' . $template . '.php';

        new View($this->layout, $templatePath, $data);
    }
}