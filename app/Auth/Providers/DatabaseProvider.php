<?php
namespace App\Auth\Providers;

use App\Models\User;
use Doctrine\ORM\EntityManager;
use App\Auth\Providers\UserProviderInterface;

class DatabaseProvider implements UserProviderInterface
{
    protected $db;

    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }

    public function getByUsername($email)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);
    }

    public function getById($id)
    {
        return $this->db->getRepository(User::class)->find($id);
    }

    public function updateUserPasswordHash($id, $hash)
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'password' => $hash
        ]);

        $this->db->flush();
    }

    public function getUserByRememberIdentifier($identifier)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'remember_identifier' => $identifier
        ]);

    }

    public function clearUserRememberToken($id)
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'remember_identifier' => null,
            'remember_token' => null,
        ]);

        $this->db->flush();
    }

    public function setUserRememberToken($id, $identifier, $hash)
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $hash
        ]);

        $this->db->flush();
    }
}