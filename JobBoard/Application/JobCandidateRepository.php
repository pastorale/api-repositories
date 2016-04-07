<?php
namespace AppBundle\Repositories\JobBoard\Application;

use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseRepository;

class JobCandidateRepository extends BaseRepository
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
            ->andWhere($queryBuilder->expr()->like('u.enabled', '?3'))
            ->andWhere($queryBuilder->expr()->like('o.enabled', '?3'))
            ->andWhere($queryBuilder->expr()->like('p.enabled', '?3'))
            ->andWhere($queryBuilder->expr()->like('u.locked', '?4'))
            ->setParameters(array(1 => $userCode, 2 => $orgCode, 3 => true, 4 => false));
//        $sql = $position->getQuery()->getSQL();
        return $position->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }


}