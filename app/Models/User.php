<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'email',
        'name',
        'password',
        'remember_token',
        'remember_identifier',
    ];
}