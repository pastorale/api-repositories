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
        $position = $this->createQueryBuilder('p')->join('p.employee', 'u', 'WITH', 'u.code = ?1')
            ->join('p.employer', 'o', 'WITH', 'o.code = ?2')
            ->setParameter(1, $userCode)->setParameter(2, $orgCode);
        return $position->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}