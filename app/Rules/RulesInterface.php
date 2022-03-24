<?php
namespace App\Rules;

interface RulesInterface
{
    public function validate($field, $value, $params, $fields);
}