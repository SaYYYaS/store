<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CmsRepository extends EntityRepository{

    public function getCmsByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery("SELECT cms FROM StoreBackendBundle:Cms AS cms WHERE cms.jeweler = :user")
            ->setParameter('user',$user);
        return $query->getResult();
    }

    /**
     * Get count suppliers by user id
     * @param null $user
     * @return int
     * SELECT count(`cms`.id) AS nbrcmss FROM `cms` WHERE `cms`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()
            ->createQuery("SELECT count(cms) as nbrcmss FROM StoreBackendBundle:Cms AS cms WHERE cms.jeweler = :user")
            ->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }
} 