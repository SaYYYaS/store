<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository{

    public function getProductByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM StoreBackendBundle:Product AS p WHERE p.jeweler = :user")
            ->setParameter('user',$user);
        return $query->getResult();
    }
} 