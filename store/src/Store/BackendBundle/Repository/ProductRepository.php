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
            ->createQuery("
            SELECT p
            FROM StoreBackendBundle:Product AS p
            WHERE p.jeweler = ?1
            ")
            ->setParameter(1,$user);
        return $query->getResult();
    }

    /**
     * Get count product by user id
     * @param null $user
     * @return array
     * SELECT count(`product`.id) AS nbprods FROM `product` WHERE `product`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(p.id) AS nbprods
            FROM StoreBackendBundle:Product AS p
            WHERE p.jeweler = :user
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }
} 