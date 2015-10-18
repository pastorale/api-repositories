<?php
namespace AppBundle\Repositories\Core\User;

use AppBundle\Entity\Organisation\Position;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getTest()
    {
        return true;
    }
}