<?php
namespace App\Rules;

use App\Rules\RulesInterface;
use Doctrine\ORM\EntityManager;


class ExistsRule implements RulesInterface
{
    protected $db;

    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }
    public function validate($field, $value, $params, $fields)
    {
        $result = $this->db->getRepository($params[0])->findOneBy([
            $field => $value
        ]);

        return $result === null;
    }
}