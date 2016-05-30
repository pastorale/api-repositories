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
    public function findByAttributeGroups($attribute, ArrayCollection $groups, $childClassname = null)
    {
        $qb = $this->createQueryBuilder('ace');
        $expr = $qb->expr();
        $qb->where($expr->like('ace.attributes', '%[' . $attribute . ']%'))
            ->andWhere($expr->in('ace.group', $groups));

        if ($childClassname !== null) {
            $qb->andWhere('ace INSTANCE OF :childClassName')
                ->setParameter(':childClassName', $childClassname);
        }
//        return $orgQB->getQuery()->setMaxResults(1)->getOneOrNullResult();
        return null;
    }
}