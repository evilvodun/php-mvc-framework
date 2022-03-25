<?php
namespace App\Rules;

use App\Models\User;
use App\Rules\RulesInterface;

class ExistsRule implements RulesInterface
{
    public function validate($field, $value, $params, $fields)
    {
        return User::where($field, $value)->first() === null;
    }
}