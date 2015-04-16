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
//        $query = $this->getEntityManager()
//            ->createQuery(" SELECT s
//                            FROM StoreBackendBundle:Supplier AS s
//                            JOIN s.product AS p
//                            WHERE p.jeweler = :user
//                            GROUP BY s.id")
//            ->setParameter('user',$user);
//        return $query->getResult();

        $query = $this->getSupplierByUserBuilder($user)->getQuery();
        return $query->getResult();
    }


    public function getSupplierByUserBuilder($user = null){
        $queryBuilder = $this->createQueryBuilder('s')
            ->select('s')
            ->join('s.product','p')
            ->where('p.jeweler = :user')
            ->groupBy('s.id')
            ->setParameter(':user', $user);
        return $queryBuilder;
    }

    /**
     * Get count suppliers by user id
     * @param null $user
     * @return array
     * SELECT count(`product`.id) AS nbprods FROM `product` WHERE `product`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery("
                            SELECT count(DISTINCT s)
                            FROM StoreBackendBundle:Supplier AS s
                            JOIN s.product AS p
                            WHERE p.jeweler = :user
                            ")
            ->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }
} 