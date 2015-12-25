<?php
namespace AppBundle\Repositories\Organisation;

use AppBundle\Entity\Organisation\Position;
use Doctrine\ORM\EntityRepository;

class PositionRepository extends EntityRepository
{
    /**
     * @param $orgCode
     * @param $userCode
     * @return Position
     */
    public function findOneByVerificationCode($orgCode, $userCode)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $position = $queryBuilder->join('p.employee', 'u', 'WITH', 'u.code = ?1')
            ->join('p.employer', 'o', 'WITH', 'o.code = ?2')
            ->where($queryBuilder->expr()->like('p.enabled', '?3'))
            ->setParameters(array(1 => $userCode, 2 => $orgCode, 3 => true));
        return $position->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}