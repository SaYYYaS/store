<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository{

    public function getCategoryByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery("SELECT cat FROM StoreBackendBundle:Category AS cat WHERE cat.jeweler = :user")
            ->setParameter('user',$user);
        return $query->getResult();
    }
} 