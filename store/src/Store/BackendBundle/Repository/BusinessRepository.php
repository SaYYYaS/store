<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BusinessRepository extends EntityRepository{

    public function getBusinessByUser($user = null, $nbr = 5){
        {
            $query = $this->getEntityManager()
                ->createQuery(
                    "
                    SELECT b
                    FROM StoreBackendBundle:Business AS b
                    JOIN b.product AS p
                    JOIN p.jeweler AS j
                    WHERE p.jeweler = :user
                    "
                )
                ->setMaxResults($nbr)
                ->setParameter(':user', $user);
            return $query->getResult();
        }
    }
}