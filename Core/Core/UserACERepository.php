<?php
namespace AppBundle\Repositories\Core\Core;

use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class UserACERepository extends EntityRepository
{
    /**
     * @param $user
     * @param $childClassname
     */
    public function findByAttributeUser($user, $childClassname = null,$allowed)
    {
        //return HandbookUserACE
    }
}