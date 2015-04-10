<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SupplierRepository extends EntityRepository{

    public function getSupplierByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery(" SELECT s
                            FROM StoreBackendBundle:Supplier s
                            JOIN s.product p
                            WHERE p.jeweler = :user
                            GROUP BY p.jeweler")

            ->setParameter('user',$user);
        return $query->getResult();
    }
} 