<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 23/04/15
 * Time: 12:29
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductMetaRepository extends EntityRepository {


    /**
     * Fiche meta , description compo et resume dans tout les produits
     * nbr bij total et les bijou qui ont une descr,comp et resume
     * @param null $user
     * @return mixed
     */
    public function getProductCompletionMetas($user = null){

        $query = $this->getEntityManager()->createQuery(
            "
             SELECT count(pm)
             FROM StoreBackendBundle:ProductMeta as pm
             JOIN pm.product as p
             WHERE p.jeweler = :user
             AND pm.metaDescription IS NOT NULL
             AND pm.metaKeyword IS NOT NULL
             AND pm.metaTitle IS NOT NULL
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }
} 