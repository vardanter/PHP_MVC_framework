<?php

namespace engine\classes;

use engine\Application;
use engine\interfaces\UrlRulesInterface;

class QueryParser
{
    protected $requestUri;
    protected $queryString;
    protected $urlRulesManager;

    public $controller;
    public $action;
    
    public function __construct(UrlRulesInterface $urlRulesManager)
    {
        $this->queryString = $_SERVER['QUERY_STRING'];
        $this->requestUri = str_replace(['?', $this->queryString], '', $_SERVER['REQUEST_URI']);
        $this->urlRulesManager = $urlRulesManager;

        $this->parse();
    }

    protected function parse()
    {
        $rule = explode('@', $this->getRule());
        $this->controller = !empty($rule) ? $rule[0] : Application::instance()->getConfig()->defaultController;
        $this->action = count($rule) > 1 ? $rule[1] : 'index';
    }
    
    protected function getRule()
    {
        $rule = $this->urlRulesManager->getRule($this->requestUri);
        return $rule !== null ? $rule['rule'] : null;
    }
}