<?php

namespace CodersLabBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MainController extends Controller {

    /**
     * @Route("/", name = "mainSite")
     * @Template()
     */
    public function MainSiteAction(){

        return [];
    }
}
