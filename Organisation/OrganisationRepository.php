<?php
namespace AppBundle\Repositories\Organisation;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class OrganisationRepository extends EntityRepository
{
    /**
     * @param $orgCode
     * @param $userCode
     * @return Position
     */
    public function findOneByVerificationCode($orgCode, $enabled = null)
    {
        $queryBuilder = $this->createQueryBuilder('o');
        if ($enabled !== null) {
            $orgQB = $queryBuilder
                ->where($queryBuilder->expr()->eq('o.enabled', '?2'))->setParameter(2, $enabled);
        }
        $orgQB = $queryBuilder->andWhere($queryBuilder->expr()->eq('o.code', '?1'))->setParameter(1, $orgCode);
//            ->setParameters(array(1 => $orgCode, 2 => true));
//        $sql = $position->getQuery()->getSQL();
        return $orgQB->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}