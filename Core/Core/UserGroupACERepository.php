<?php
namespace AppBundle\Repositories\Core\Core;

use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class UserGroupACERepository extends EntityRepository
{
    /**
     * @param $orgCode
     * @param $userCode
     * @return Position
     * // TODO implementation
     */
    public function findByAttributeGroups($attribute, Collection $groups, $childClassname = null)
    {
        $qb = $this->createQueryBuilder('ace');
        $expr = $qb->expr();

        $qb->where($expr->like('ace.attributes', ':attribute'))
            ;
        if($groups->count()>0) {
            $qb->andWhere( $expr->in( 'ace.group', $groups->getValues() ) );
        }
        if ($childClassname !== null) {
            $qb->andWhere('ace INSTANCE OF :childClassName')
                ->setParameter(':childClassName', $childClassname);
        }
        $qb->setParameter('attribute','%[' . $attribute . ']%');
        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
//        return null;
    }
}