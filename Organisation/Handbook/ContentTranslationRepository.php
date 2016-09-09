<?php
namespace AppBundle\Repositories\Organisation\Handbook;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use AppBundle\Entity\Organisation\Handbook\Handbook;

class ContentTranslationRepository extends TranslationRepository
{
    /**
     * step 1: get array list if of content by hanbook
     * @param Handbook $handbook
     * @return array
     */
    public function getContentsByHandbook(Handbook $handbook){
        $sections = $handbook->getSections();
        $result =[];
        foreach ($sections as $section){
            $contents = $section->getContents();
            foreach ($contents as $content){
                $result[]=$content->getId();
            }
        }
        return $result;
    }

    /**
     *
     * step 2: get array id of content after search by tranlated field
     * @param $class
     * @param Handbook $handbook
     * @param $keyword
     * @param $listSectionLimitByHandbook
     * @return array
     */
    public function findObjectByTranslatedFields(Handbook $handbook,$keyword)
    {
        $listContentLimitByHandbook = $this->getContentsByHandbook($handbook);
        if(count($listContentLimitByHandbook)===0) {
            return [];
        }else{
            $strListContentLimitByHandbook  = '('.implode(',',$listContentLimitByHandbook).')';
        }
        $translationMeta = $this->getClassMetadata(); // table inheritance support
        $dql = "SELECT trans.foreignKey FROM {$translationMeta->rootEntityName} trans";
        $dql .= ' WHERE trans.objectClass = :class';
        $dql .= ' AND ';
        $dql .= ' trans.foreignKey IN '.$strListContentLimitByHandbook;
        $dql .= ' AND ';
        $dql .= '((trans.field = :title AND trans.content LIKE :valueTitle)';
        $dql .= ' OR';
        $dql .= '(trans.field = :htmlText AND trans.content LIKE :valueHtmlText))';
        $q = $this->_em->createQuery($dql);
        $q->setParameter('class','AppBundle\Entity\Organisation\Handbook\Content');
        $q->setParameter('valueTitle','%'.$keyword.'%');
        $q->setParameter('valueHtmlText','%'.$keyword.'%');
        $q->setParameter('title','title');
        $q->setParameter('htmlText','htmlText');
        $result = $q->getArrayResult();
        return $result;

    }
}