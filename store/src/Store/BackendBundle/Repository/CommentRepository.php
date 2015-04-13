<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository{
    /**
     * Get count comments by user id
     * @param null $user
     * @return array
     * SELECT count(`comment`.id) AS nbprods FROM `comment` WHERE `comment`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(com.id) AS nbrcoms
            FROM StoreBackendBundle:Comment AS com
            JOIN com.product AS p
            WHERE p.jeweler = :user
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }

    /**
     * Get list of comments
     * @param null $user
     * @param int $nbr to define count to retrive
     * @return array
     */
    public function getCommentsByUser($user = null, $nbr = 5){
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT com FROM StoreBackendBundle:Comment AS com JOIN com.product AS p WHERE p.jeweler = :user ORDER BY com.dateCreated DESC")
            ->setMaxResults($nbr)
            ->setParameter(':user', $user);
        return $query->getResult();
    }
}