<?php

namespace App\Utils;

class Validator
{
    public function validate(array $fields)
    {
        foreach ($fields as $field) {
            $fieldValue = $field[0];
            $rules      = explode('|', $field[1]);

            foreach ($rules as $rule) {
                switch ($rule) {
                    case 'required':
                        empty(trim($fieldValue)) && throw new \Exception('Please, complete all required fields.');
                        break;
                    case 'email':
                        !filter_var($fieldValue, FILTER_VALIDATE_EMAIL) && throw new \Exception('Please, enter a valid email.');
                        break;
                    default:
                        break;
                } 
            }
        }

        return true;
    }
}