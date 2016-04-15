<?php
namespace AppBundle\Repositories\JobBoard\Application;

use AppBundle\Entity\JobBoard\Application\JobCandidate;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseRepository;
use Doctrine\Common\Collections\Criteria;

class CandidateReviewerRepository extends BaseRepository
{
    public function findOneByCandidatePosition(JobCandidate $candidate, Position $position, Criteria $criteria = null)
    {
        if ($criteria === null) {
            $criteria = Criteria::create();
        }
        $criteria
            ->andWhere(Criteria::expr()->eq("position", $position))
            ->setFirstResult(0)
            ->setMaxResults(1);
// todo
        /**
         *  CandidateReviewerRepository
         * HATEOAS service-userRetriever-getLoggedInUser-getPosition
         */
        $reviewers = $candidate->getReviewers()->matching($criteria);
        return $reviewers->get(0);

    }


}