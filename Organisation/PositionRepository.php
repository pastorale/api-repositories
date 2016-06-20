<?php
namespace AppBundle\Repositories\Organisation;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class PositionRepository extends EntityRepository
{
    /**
     * @param User $user
     * @param Organisation $organisation
     * @param Criteria|null $criteria
     * @return Position|null
     */
    public function findOneByEmployeeEmployer(User $user, Organisation $organisation = null, Criteria $criteria = null)
    {
        if ($criteria === null) {
            $criteria = Criteria::create();
        }
        if ($organisation === null) {
            $criteria->andWhere(Criteria::expr()->eq("enabled", true))
                ->setFirstResult(0)
                ->setMaxResults(1);
            if ($user->getPositions()->count() > 1) {
                $criteria->andWhere(Criteria::expr()->eq("defaultPos", true));
            }
        } else {
            if (!$organisation->isEnabled()) {
                return null;
            }
            $criteria
                ->andWhere(Criteria::expr()->eq("employer", $organisation))
                ->andWhere(Criteria::expr()->eq("enabled", true))
                ->setFirstResult(0)
                ->setMaxResults(1);
        }
        $positions = $user->getPositions()->matching($criteria);
        return $positions->get(0);
    }

    /**
     * @param $orgCode
     * @param $userCode User
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