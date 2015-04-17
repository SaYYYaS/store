<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JewelerRepository extends EntityRepository{

    public function getJewelerByUser($user = null){
        {
            $query = $this->getEntityManager()
                ->createQuery(
                "
                 SELECT j
                 FROM StoreBackendBundle:Jeweler AS j
                 WHERE j.id = :user
                "
                )
                ->setParameter(':user', $user);
            return $query->getOneOrNullResult();
        }
    }
}