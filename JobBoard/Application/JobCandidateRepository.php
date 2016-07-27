<?php
namespace AppBundle\Repositories\JobBoard\Application;

use AppBundle\Entity\JobBoard\Application\JobCandidate;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseRepository;
use Doctrine\Common\Collections\Criteria;

class JobCandidateRepository extends BaseRepository
{
    /**
     * @param string $code
     * @return JobCandidate|null
     */
    public function findOneByInvitationCodeStr($code)
    {
        $queryBuilder = $this->createQueryBuilder('c')->join('c.invitationCode', 'invitation_code');
        $expr = $queryBuilder->expr();
        $queryBuilder
            ->where($expr->eq('c.enabled', 1))
            ->andWhere($expr->andX($expr->eq('invitation_code.code', $expr->literal($code)), $expr->eq('invitation_code.enabled', 1)));
//        $sql = $position->getQuery()->getSQL();
        return $queryBuilder->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}