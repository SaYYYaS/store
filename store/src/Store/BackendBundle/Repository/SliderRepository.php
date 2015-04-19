<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 10/04/15
 * Time: 16:28
 */

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SliderRepository extends EntityRepository{

    public function getSlidersByUser($user = null){
        $query = $this->getSlidersByUserBuilder($user)->getQuery();
        return $query->getResult();
    }

    public function getSlidersByUserBuilder($user = null){
        $queryBuilder = $this->createQueryBuilder('slider')
            ->select('slider')
            ->join('slider.product','p')
            ->where('p.jeweler = :user')
            ->setParameter(':user', $user);
        return $queryBuilder;
    }

    /**
     * Get count suppliers by user id
     * @param null $user
     * @return int
     * SELECT count(`slider`.id) AS nbrsliders FROM `slider` WHERE `slider`.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()
            ->createQuery("SELECT count(slider) as nbrsliders FROM StoreBackendBundle:slider AS slider WHERE slider.jeweler = :user")
            ->setParameter(':user', $user);
        return $query->getSingleScalarResult();
    }
} 