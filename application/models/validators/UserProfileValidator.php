<?php

namespace application\models\validators;

use engine\classes\Model;
use engine\classes\Translate;

class UserProfileValidator
{
    protected $model;
    protected $errors;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function rules()
    {
        return [
            'fullname' => [
                'required' => [
                    'value' => true,
                    'message' => Translate::t('errors', 'required', ['"'.Translate::t('site', 'fullname').'"'])
                ],
                'match' => [
                    'pattern' => '/^[A-zА-я ]+$/i',
                    'message' => Translate::t('errors', 'match', ['"'.Translate::t('site', 'fullname').'"'])
                ]
            ]
        ];
    }

    public function validate()
    {
        $rules = $this->rules();

        foreach ($rules as $_attr => $attrRule) {
            $attr = $this->model->{$_attr};

            foreach ($attrRule as $key => $rule) {
                switch ($key) {
                    case 'required':
                        if ($rule['value'] && empty($attr)) {
                            $this->errors[$_attr][] = $rule['message'];
                        }
                        break;
                    case 'match':
                        if (!preg_match($rule['pattern'], $attr)) {
                        $this->errors[$_attr][] = $rule['message'];
                    }
                    break;
                }
                if (!empty($this->errors[$_attr])) {
                    break;
                }
            }
        }
        if (!empty($this->errors)) {
            $this->model->setErrors($this->errors);
        }
        return empty($this->errors);
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function getError($key)
    {
        return isset($this->errors[$key]) ? $this->errors[$key] : null;
    }
}