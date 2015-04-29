<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 29/04/15
 * Time: 18:17
 */

namespace Store\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Store\BackendBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface {


    public function load(ObjectManager $manager)
    {

        $cat2 = new Category();
        $cat2->setActive('1');
        $cat2->setTitle('Pas cher !');
        $cat2->setDescription('Vraiment pas cher!');
        $manager->persist($cat2);

        $cat3 = new Category();
        $cat3->setActive('0');
        $cat3->setTitle('Un peu cher !');
        $cat3->setDescription('Vraiment un peu cher!');
        $manager->persist($cat3);

        $manager->flush();
    }
}