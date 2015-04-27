<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 27/04/15
 * Time: 14:09
 */

namespace Store\BackendBundle\Listener;

use Doctrine\ORM\Mapping\Entity;
use Store\BackendBundle\Notification\Notification;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Entity\Category;
use Doctrine\ORM\EntityManager;

class ProductListener {

    /**
     * @var \Store\BackendBundle\Notification\Notification
     */
    private $notification;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Constructeur qui reçoit en argument le service Notification
     * @param Notification $notification
     * @internal param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(Notification $notification){

        $this->notification = $notification;
    }

    /**
     * Cette méthode sera appelée depuis mon services.yml
     * et reçoit en argument mon event Doctrine 2
     */
    public function postUpdate(LifecycleEventArgs $args){

        // Je récupère mon objet après l'event
        $entity = $args->getEntity();

        if($entity instanceof Product){
            if($entity->getQuantity() < 5){
                $this->notification->notify(
                    $entity->getId(),
                    'Le produit "' . $entity . '" est presque épuisé.' ,
                    'product',
                    'warning'
                );
            }
            elseif($entity->getQuantity() == 1){
                $this->notification->notify(
                    $entity->getId(),
                    'Le produit "' . $entity . '" est unique.' ,
                    'product',
                    'danger'
                );
            }
            // Permet de virer la notif si le produits à plus de 6 qte
            else{
                $key = $entity->getId();
                $tabsession = $this->notification->getSession()->get('product');

                // Nous stockons dans ce tableau la notif
                // avec un message, une priorité et une date
                unset($tabsession[$key]);

                // Enfin nous enregistrons le tableau des notification en session
                $this->notification->getSession()->set('product', $tabsession);
            }
        }
    }

    public function postPersist(lifecycleEventArgs $args){
        $this->postUpdate($args);
    }

    public function preUpdate(lifecycleEventArgs $args){

        $entity = $args->getEntity();

        if($entity instanceof Product){
            // Update date update
            $entity->setDateUpdated(new \DateTime('now'));
            // Set slug
            $entity->setSlug($this->slugifyTitle($entity->getTitle()));
        }
    }

    /**
     * Permet de slugifier le titre du produit
     * @param $str
     * @internal param \Store\BackendBundle\Entity\Product $entity
     * @return string
     */
    private function slugifyTitle($str){

        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        $slug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a, $b, $str)));
        return $slug;
    }
} 