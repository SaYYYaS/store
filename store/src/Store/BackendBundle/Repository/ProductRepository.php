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
        $query = $this->getProductByUserBuilder($user)->getQuery();
        return $query->getResult();
    }

    public function getProductByUserBuilder($user){
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.jeweler = ?1')
            ->setParameter(1, $user);
        return $queryBuilder;
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

    /**
     * Return product quantity by user filtered by min qte
     * @param null $user
     * @param int $min_qte default = 10
     * @return array
     */
    public function getQuantitiesByUser($user = null, $min_qte = 10){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT p.quantity as quantity, p.title, p.id
            FROM StoreBackendBundle:Product AS p
            WHERE p.jeweler = :user
            AND p.quantity <= :min_qte
            ORDER BY quantity DESC
            "
        )->setParameters([':user' => $user, ':min_qte' => $min_qte]);
        return $query->getResult();
    }

    public function getLikesByUser($user = null){
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT count(p)
            FROM StoreBackendBundle:Product AS p
            JOIN p.user as u
            WHERE p.jeweler = ?1
            ")
            ->setParameter(1,$user);
        return $query->getSingleScalarResult();
    }

    /**
     * Fiche meta_title , meta_description, keyword et resume dans tout les produits
     * nbr bij total et les bijou qui ont une descr,comp et resume
     * @param null $user
     * @return mixed
     */
    public function getProductCompletionDetails($user = null){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(p)
            FROM StoreBackendBundle:Product as p
            WHERE p.jeweler = :user
            AND p.summary IS NOT NULL
            AND p.description IS NOT NULL
            AND p.composition IS NOT NULL
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }

    /**
     * DQL Syntax with Form
     * @param int $user
     * @return array
     */
    public function activeProductQueryBuilder(){
        /**
         * Le formulaire ProductType attend un objet createQueryBuilder()
         *  ET NON PAS l'objet createQuery()
         */
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.active = 1');
        return $queryBuilder;
    }
} 