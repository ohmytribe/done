<?php

namespace Omt\TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LandingController extends Controller
{
    /**
     * @Route("/", name="landing")
     * @Template("@OmtTodoBundle:landing:welcome.html.twig")
     */
    public function welcomeAction()
    {
        return array();
    }
}
