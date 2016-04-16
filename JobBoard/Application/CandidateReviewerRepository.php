<?php
namespace AppBundle\Repositories\JobBoard\Application;

use AppBundle\Entity\JobBoard\Application\JobCandidate;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseRepository;
use Doctrine\Common\Collections\Criteria;

class CandidateReviewerRepository extends BaseRepository
{
    public function findOneByCandidatePosition(JobCandidate $candidate, Position $position = null, Criteria $criteria = null)
    {
        if ($position === null) {
            return null;
        }
        if ($criteria === null) {
            $criteria = Criteria::create();
        }
        $criteria
            ->andWhere(Criteria::expr()->eq("position", $position))
            ->setFirstResult(0)
            ->setMaxResults(1);

        $reviewers = $candidate->getReviewers()->matching($criteria);
        return $reviewers->get(0);

    }


}