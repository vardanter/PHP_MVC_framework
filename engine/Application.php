<?php

namespace engine;


use engine\classes\QueryParser;
use engine\classes\UrlRulesManager;
use engine\classes\WebApplication;

class Application
{
    private static $_instance;
    private $_config;
    
    const WEB_APP = 'web';
    
    private function __construct()
    {
        
    }
    
    private function __clone(){}
    
    public function createApplication(array $config, string $applicationType = 'web')
    {
        $this->_config = $config;
        $urlRules = isset($this->_config['urlRules']) ? $this->_config['urlRules'] : [];
        
        $queryParser = new QueryParser(new UrlRulesManager($urlRules));

        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = $this->_config['lang'];
        }
        
        switch ($applicationType) {
            case self::WEB_APP:
                WebApplication::create($queryParser);
                break;
        }
    }
    
    public static function instance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();            
        }
        
        return self::$_instance;
    }
    
    public function getConfig()
    {
        return (object)$this->_config;
    }
}