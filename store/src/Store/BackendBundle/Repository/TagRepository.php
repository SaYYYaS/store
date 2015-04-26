<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 26/04/2015
 * Time: 22:18
 */

namespace Store\BackendBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository {

    public function getTagsByUser($user){
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->join('t.product','p')
            ->where('p.jeweler = :user')
            ->setParameter(':user',$user)
        ;

        return $query->getQuery()->getResult();
    }
}