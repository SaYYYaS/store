<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository{
    /**
     * Get count order by user id
     * @param null $user
     * @return array
     * SELECT count(`comment`.id) AS nbrords FROM `comment` WHERE `comment`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT count(ord.id) AS nbrords
            FROM StoreBackendBundle:Orders AS ord
            WHERE ord.jeweler = :user
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }

    /**
     * Get sum order by user id
     * @param null $user
     * @return array
     */
    public function getSumOrdersByUser($user){
        $query = $this->getEntityManager()->createQuery(
            "
            SELECT SUM(ord.total) AS total
            FROM StoreBackendBundle:Orders AS ord
            WHERE ord.jeweler = :user
            "
        )->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }

    /**
     * Get list of orders
     * @param null $user
     * @param int $nbr to define count to retrieve
     * @return array
     */
    public function getOrdersByUser($user = null, $nbr = 5){
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT ord
            FROM StoreBackendBundle:Orders AS ord
            LEFT JOIN ord.product as p
            WHERE p.jeweler = :user
            ORDER BY ord.dateCreated DESC")
            ->setMaxResults($nbr)
            ->setParameter(':user', $user);
        return $query->getResult();
    }

    /**
     * @param null $user
     * @param \DateTime $date
     * @param \DateTime $now
     * @return mixed
     */
    public function getLastSalesByUser($user = null,\DateTime $date, \DateTime $now = null){
        if(is_null($now)){
            $now = new \DateTime('now');
        }
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT COUNT(o) AS sales, DATE_FORMAT(o.date,'%Y-%m') AS month_year
            FROM StoreBackendBundle:Orders AS o
            WHERE o.jeweler = :user
            GROUP BY month_year
            HAVING month_year BETWEEN :date AND :now")
            ->setParameters([
                ':user' => $user,
                ':date' => $date->format('Y-m'),
                ':now' => $now->format('Y-m')
            ]);
        dump($date->format('Y-m'));
        return $query->getResult();

    }
} 