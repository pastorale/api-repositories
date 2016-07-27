<?php
namespace AppBundle\Repositories\JobBoard\Application;

use AppBundle\Entity\JobBoard\Application\JobCandidate;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseRepository;
use Doctrine\Common\Collections\Criteria;

class JobCandidateRepository extends BaseRepository
{
    /**
     * @param $code
     * @return JobCandidate|null
     */
    public function findOneByInvitationCode($code)
    {
        $queryBuilder = $this->createQueryBuilder('c')->join('c.invitationCode', 'invitation_code');
        $expr = $queryBuilder->expr();
        $queryBuilder
            ->where($expr->eq('c.enabled', true))
            ->andWhere($expr->andX($expr->eq('invitation_code.code', $code), $expr->eq('invitation_code.enabled', true)));
//        $sql = $position->getQuery()->getSQL();
        return $queryBuilder->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}