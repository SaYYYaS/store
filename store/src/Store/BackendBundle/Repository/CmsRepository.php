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
} 