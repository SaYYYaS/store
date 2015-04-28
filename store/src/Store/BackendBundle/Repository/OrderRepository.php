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
     *      TODO:       JOIN ord.orderDetail as od
     */
    public function getOrdersByUser($user = null, $nbr = 5){
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT ord
            FROM StoreBackendBundle:Orders AS ord
            JOIN ord.details as od
            JOIN ord.product as p
            WHERE ord.jeweler = :user
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
    public function getStatsLastSalesByUser($user,\DateTime $date, \DateTime $now = null){
        if(is_null($now)){
            $now = new \DateTime('now');
        }
        $query = $this->getEntityManager()
            ->createQuery("
            SELECT COUNT(o) AS sales, DATE_FORMAT(o.dateCreated,'%Y-%m') AS month_year
            FROM StoreBackendBundle:Orders AS o
            WHERE o.jeweler = :user
            GROUP BY month_year
            HAVING month_year BETWEEN :date AND :now")
            ->setParameters([
                ':user' => $user,
                ':date' => $date->format('Y-m'),
                ':now' => $now->format('Y-m')
            ]);
        return $query->getResult();
    }

    /**
     * Requete qui me sort le nb de comamndes sur les 6 derniers mois
     *
     */
    public function getOrderGraphByMYUser($user, $month, $year){

        $query = $this->getEntityManager()
            ->createQuery("
            SELECT count(o) AS nb
            FROM StoreBackendBundle:Order o
            WHERE o.jeweler = :user
            AND MONTH(o.dateCreated) = :month
            AND YEAR(o.dateCreated) = :year
            ")->setParameters([
            ':user' => $user,
            ':month' => $month,
            ':year' => $year
        ]);
    }

    /**
     * Requete qui me sort le nb de comamndes sur les 6 derniers mois
     *
     */
    public function getOrderGraphByUser($user,$dateBegin){

        $query = $this->getEntityManager()
            ->createQuery("
            SELECT count(o) AS nb, DATE_FORMAT(:dateBegin,'%Y-m') AS d
            FROM StoreBackendBundle:Order o
            WHERE o.jeweler = :user
            AND MONTH(o.dateCreated) = :month
            AND YEAR(o.dateCreated) = :year
            ")->setParameters([
                ':user' => $user,
                ':dateBegin' => $dateBegin->format('Y-m-d'),
                ':month' => $dateBegin->format('m'),
                ':year' => $dateBegin->format('Y')
            ]);
    }
} 