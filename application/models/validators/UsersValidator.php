<?php

namespace application\models\validators;

use engine\classes\Model;
use engine\classes\Translate;

class UsersValidator
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
            'email' => [
                'required' => [
                    'value' => true,
                    'message' => Translate::t('errors', 'required', ['"'.Translate::t('site', 'email').'"'])
                ],
                'match' => [
                    'pattern' => "/^[A-z0-9'.1234z_%+-]+@[A-z0-9.-]+.[A-z]{2,4}$/i",
                    'message' => Translate::t('errors', 'match', ['"'.Translate::t('site', 'email').'"'])
                ],
                'unique' => [
                    'message' => Translate::t('errors', 'email_unique')
                ]
            ],
            'phone' => [
                'required' => [
                    'value' => true,
                    'message' => Translate::t('errors', 'required', ['"'.Translate::t('site', 'phone').'"'])
                ],
                'match' => [
                    'pattern' => '/[+][0-9]{6,14}/i',
                    'message' => Translate::t('errors', 'match', ['"'.Translate::t('site', 'phone').'"'])
                ],
                'unique' => [
                    'message' => Translate::t('errors', 'phone_unique')
                ]
            ],
            'password' => [
                'required' => [
                    'value' => true,
                    'message' => Translate::t('errors', 'required', ['"'.Translate::t('site', 'password').'"'])
                ],
                'match' => [
                    'pattern' => '/^[A-zА-я0-9!#&@]+$/i',
                    'message' => Translate::t('errors', 'match', ['"'.Translate::t('site', 'password').'"'])
                ],
                'length' => [
                    'min' => [
                        'value' => 6,
                        'message' => Translate::t('errors', 'length', ['"'.Translate::t('site', 'password').'"', 6])
                    ]
                ]
            ],
            'confirm_password' => [
                'same' => [
                    'el' => $this->model->password,
                    'message' => Translate::t('errors', 'same', ['"'.Translate::t('site', 'confirm_password').'"', '"'.Translate::t('site', 'password').'"'])
                ]
            ],
            'agreement' => [
                'required' => [
                    'value' => true,
                    'message' => Translate::t('errors', 'agreement')
                ],
            ],
            'avatar' => [
                'required' => [
                    'value' => true,
                    'message' => Translate::t('errors', 'avatar_empty')
                ],
                'mime_type' => [
                    'value' => [
                        'image/jpeg',
                        'image/gif',
                        'image/png',
                    ],
                    'message' => Translate::t('errors', 'avatar_mime_type')
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
                    case 'length':
                        if (isset($rule['min']) && mb_strlen($attr, 'utf-8') < $rule['min']['value']) {
                            $this->errors[$_attr][] = $rule['min']['message'];
                        }
                        if (isset($rule['max']) && mb_strlen($attr, 'utf-8') > $rule['max']['value']) {
                            $this->errors[$_attr][] = $rule['max']['message'];
                        }
                        break;
                    case 'same':
                        if ($attr !== $rule['el']) {
                            $this->errors[$_attr][] = $rule['message'];
                        }
                    break;
                    case 'mime_type':
                        if (!empty($attr['tmp_name'][$_attr])) {
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime_type = finfo_file($finfo, $attr['tmp_name'][$_attr]);
                            if (!in_array($mime_type, $rule['value'])) {
                                $this->errors[$_attr][] = $rule['message'];
                            }
                        }
                    break;
                    case 'unique':
                        $user = $this->model->find($_attr, $_attr . '=:attr', [':attr' => ['value' => $attr, 'type' => \PDO::PARAM_STR]])->one();
                        if (!empty($user)) {
                            $this->errors[$_attr][] = $rule['message'];
                        }
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