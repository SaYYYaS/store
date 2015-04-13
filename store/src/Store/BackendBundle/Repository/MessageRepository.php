<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository{
    /**
     * Get count Messages by user id
     * @param null $user
     * @return array
     * SELECT count(`Message`.id) AS nbprods FROM `Message` WHERE `Message`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(com.id) AS nbrcoms
            FROM StoreBackendBundle:Message AS com
            JOIN com.product AS p
            WHERE p.jeweler = :user
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }

    /**
     * Get list of Messages
     * @param null $user
     * @param int $nbr to define count to retrive
     * @return array
     */
    public function getMessagesByUser($user = null, $nbr = 5){
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT com FROM StoreBackendBundle:Message AS com JOIN com.product AS p WHERE p.jeweler = :user ORDER BY com.dateCreated DESC")
            ->setMaxResults($nbr)
            ->setParameter(':user', $user);
        return $query->getResult();
    }
}