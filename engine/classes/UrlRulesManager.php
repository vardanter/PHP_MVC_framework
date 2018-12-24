<?php

namespace engine\classes;

use engine\interfaces\UrlRulesInterface;

class UrlRulesManager implements UrlRulesInterface
{
    protected $rules;

    public function __construct(array $rules)
    {
        $this->setRules($rules);
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function addRule(string $key, string $rule, array $params = [])
    {
        // TODO: Implement addRule() method.
    }

    public function getRule(string $url)
    {
        foreach ($this->rules as $rule) {
            $requestTypePermit = empty($rule['method']) || !empty($rule['method']) && preg_match('/' . $_SERVER['REQUEST_METHOD'] . '/i', $rule['method']);
            if ($rule['url'] === $url && $requestTypePermit) {
                return $rule;
            }
        }

        return null;
    }
}