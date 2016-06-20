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

        $qb->where($expr->like('ace.attributes',$qb->expr()->literal('%['.$attribute.']%')));
//        $qb->setParameter('attribute','%[' . $attribute . ']%');
//        $qb->setParameter('attribute',$qb->expr()->literal('%['.$attribute.']%'));

        if($groups->count()>0) {
            $qb->andWhere( $expr->in( 'ace.userGroup', ':groups' ) );
            $qb->setParameter( 'groups', $groups->getValues());

        }
        if ($childClassname !== null) {
            $qb->andWhere('ace INSTANCE OF '.$childClassname);
            // eg: AppBundle\ACEEntities\Organisation\Handbook\HandbookUserGroupACE
//                ->setParameter('childClassName', $childClassname);
        }

        $x = $qb->getQuery();
        $sql = $x->getSQL();
        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
//        return null;
    }
}