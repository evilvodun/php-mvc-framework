<?php

namespace App\Auth\Providers;

use App\Models\User;
use App\Auth\Providers\UserProviderInterface;

class DatabaseProvider implements UserProviderInterface
{

    public function getByUsername($email)
    {
        return User::where('email', $email)->first();
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function updateUserPasswordHash($id, $hash)
    {
        return User::find($id)->update(['password' => $hash]);
    }

    public function getUserByRememberIdentifier($identifier)
    {
        return User::where('remember_identifier', $identifier)->first();
    }

    public function clearUserRememberToken($id)
    {
        return User::find($id)->update([
            'remember_identifier' => null,
            'remember_token' => null,
        ]);
    }

    public function setUserRememberToken($id, $identifier, $hash)
    {
        return User::find($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $hash,
        ]);
    }
}
