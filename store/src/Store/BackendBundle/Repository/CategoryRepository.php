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

    /**
     * @param null $user
     * @return array
     */
    public function getCategoryByUser($user = null){
//        $query = $this->getEntityManager()
//            ->createQuery("SELECT cat FROM StoreBackendBundle:Category AS cat WHERE cat.jeweler = :user")
//            ->setParameter('user',$user);


        //J'appel la méthode getCategoryByUserBuilder() qui me retourne un objet QueryBuilder
        //Je dois donc le reconvertir en query avec getQuery() car getResult est une méthode de l'objet Query
        $query = $this->getCategoryByUserBuilder($user)->getQuery();
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

    /**
     * @param $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCategoryByUserBuilder($user) {
        /**
         * Le formulaire ProductType attend un objet createQueryBuilder()
         * ET NON PAS l'objet createQuery()
         */
        $queryBuild = $this->createQueryBuilder('c')
            ->select('c, COUNT(p) AS HIDDEN prod_count')
            ->where('c.jeweler = :user')
            ->leftJoin('c.product','p')
            ->groupBy('c.id')
            ->orderBy('prod_count','DESC')
            ->setParameter('user', $user);
        return $queryBuild;
    }
} 