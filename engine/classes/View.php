<?php

namespace engine\classes;

class View
{
    protected $layoutPath = 'application/views/layouts';
    protected $layout;
    protected $templatePath;
    protected $templateData;
    
    public function __construct(string $layout, string $templatePath, array $data = [])
    {
        $this->templatePath = $templatePath;
        $this->templateData = $data;
        $this->layout = $layout;
        
        $this->render();
    }

    protected function render()
    {
        foreach ($this->templateData as $key => $val) {
            $$key = $val;
        }
        
        ob_start();
        include($this->templatePath);
        $content = ob_get_clean();
        
        include(realpath('') . '/' . $this->layoutPath . '/' . $this->layout . '.php');
    }
}