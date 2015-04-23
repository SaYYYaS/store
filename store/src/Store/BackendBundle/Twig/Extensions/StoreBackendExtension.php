<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 23/04/15
 * Time: 18:07
 */

namespace Store\BackendBundle\Twig\Extensions;


class StoreBackendExtension extends \Twig_Extension {

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getFilters()
    {
        return [
                // Twig_SimpleFilter :
                // - 1er argument est le nom du filtre en TWIG
                // - 2 eme argument est le nom de la fonction que je vais crée
                new \Twig_SimpleFilter('state',array($this, 'state')),
        ];
    }

    public function state($state){

        switch($state){
            case 1:
                $badge = "<span class=\"label label-warning ticket-label\">Pending</span>";
                break;
            case 2:
                $badge = " <span class=\"label label-success ticket-label\">Completed</span>";
                break;
            default:
                $badge = "<span class=\"label label-danger ticket-label\">Rejected</span>";
        }
        return $badge;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'store_backend_extension';
    }


} 