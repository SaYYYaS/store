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
     * SELECT count(`Message`.id) AS nbrmessages FROM `Message` WHERE `Message`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(msg.id) AS nbrmsgs
            FROM StoreBackendBundle:Message AS msg
            JOIN msg.product AS p
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
            SELECT msg FROM StoreBackendBundle:Message AS msg  WHERE msg.jeweler = :user ORDER BY msg.dateCreated DESC")
            ->setMaxResults($nbr)
            ->setParameter(':user', $user);
        return $query->getResult();
    }
}