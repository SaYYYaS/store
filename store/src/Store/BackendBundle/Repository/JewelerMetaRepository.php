<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JewelerMetaRepository extends EntityRepository
{

    /**
     * Methode qui permet de retrouver un jeweler par son id
     * @param null $user
     * @return mixed
     */
    public function getMetasByUser($user = null, $limit = 1)
    {
        {
            $query = $this->getEntityManager()
                ->createQuery(
                "
                 SELECT jm
                 FROM StoreBackendBundle:JewelerMeta AS jm
                 join jm.jeweler as j
                 WHERE j.id = :user
                 ORDER BY jm.id DESC
                "
                )
                ->setMaxResults($limit)
                ->setParameter(':user', $user);
            return $query->getOneOrNullResult();
        }
    }


}