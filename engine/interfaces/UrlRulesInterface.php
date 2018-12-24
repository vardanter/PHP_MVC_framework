<?php

namespace engine\interfaces;

interface UrlRulesInterface
{
    public function setRules(array $rules);
    public function addRule(string $key, string $rule, array $params = []);
    public function getRule(string $key);
}