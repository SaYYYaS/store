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
            ->createQuery("
            SELECT cat
            FROM StoreBackendBundle:Category AS cat
            JOIN cat.product as p
            WHERE p.jeweler = :user
            ")
            ->setParameter('user',$user);
        return $query->getResult();
    }

    /**
     * Get count categories by user id
     * @param null $user
     * @return array
     * SELECT count(`category`.id) AS nbcats FROM `category` WHERE `category`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(c.id) AS nbcats
            FROM StoreBackendBundle:Category AS c
            WHERE c.jeweler = :user
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }
} 