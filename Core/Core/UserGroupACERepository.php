<?php
namespace AppBundle\Repositories\Core\Core;

use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class UserGroupACERepository extends EntityRepository
{
    /**
     * @param $orgCode
     * @param $userCode
     * @return Position
     * // TODO implementation
     */
    public function findByAttributeGroups($attribute, ArrayCollection $groups)
    {
        $qb = $this->createQueryBuilder('ace');
//        return $orgQB->getQuery()->setMaxResults(1)->getOneOrNullResult();
        return null;
    }
}