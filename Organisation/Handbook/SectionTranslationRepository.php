<?php
namespace AppBundle\Repositories\Organisation\Handbook;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use AppBundle\Entity\Organisation\Handbook\Handbook;

class SectionTranslationRepository extends TranslationRepository
{
    /**
     * step 1: get array list if of section by hanbook
     * @param Handbook $handbook
     * @return array
     */
    public function getSectionsByHandbook(Handbook $handbook){
        $sections = $handbook->getSections();
        $result =[];
        foreach ($sections as $section){
            $result[] = $section->getId();
        }
        return $result;
    }

    /**
     *
     * step 2: get array id of section after search by tranlated field
     * @param $class
     * @param Handbook $handbook
     * @param $keyword
     * @param $listSectionLimitByHandbook
     * @return array
     */
    public function findObjectByTranslatedFields(Handbook $handbook,$keyword)
    {
        $listSectionLimitByHandbook = $this->getSectionsByHandbook($handbook);
        if(count($listSectionLimitByHandbook)===0) {
            return [];
        }else{
            $strListSectionLimitByHandbook  = '('.implode(',',$listSectionLimitByHandbook).')';
        }
        $translationMeta = $this->getClassMetadata(); // table inheritance support
        $dql = "SELECT trans.foreignKey FROM {$translationMeta->rootEntityName} trans";
        $dql .= ' WHERE trans.objectClass = :class';
        $dql .= ' AND ';
        $dql .= ' trans.foreignKey IN '.$strListSectionLimitByHandbook;
        $dql .= ' AND ';
        $dql .= '((trans.field = :title AND trans.content LIKE :valueTitle)';
        $dql .= ' OR';
        $dql .= '(trans.field = :description AND trans.content LIKE :valueDescription))';
        $q = $this->_em->createQuery($dql);
        $q->setParameter('class','AppBundle\Entity\Organisation\Handbook\Section');
        $q->setParameter('valueTitle','%'.$keyword.'%');
        $q->setParameter('valueDescription','%'.$keyword.'%');
        $q->setParameter('title','title');
        $q->setParameter('description','description');
        $result = $q->getArrayResult();
        return $result;

    }
}