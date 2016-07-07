<?php
namespace AppBundle\Repositories\Core\Core;

use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class UserACERepository extends EntityRepository
{
    /**
     * @param      $attributes
     * @param      $user
     * @param null $childClassname
     * @param      $allowed
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByAttributeUser($attributes ,$user, $childClassname = null,$allowed)
    {
        //return HandbookUserACE
        $qb = $this->createQueryBuilder('ace');
        $expr = $qb->expr();

        $qb->where($expr->eq( 'ace.user', ':user' ));

        $qb->andWhere( $expr->eq( 'ace.allowed', ':allowed' ) );
        $qb->setParameter( 'user', $user);
        $qb->setParameter('allowed', $allowed);

        if ($childClassname !== null) {
            $qb->andWhere('ace INSTANCE OF '.$childClassname);
        }

        $temp = $qb->getQuery()->getDQL();
        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}