<?php

namespace Omt\TodoBundle\Controller;

use Omt\TodoBundle\Form\Type\RegisterType;
use Omt\TodoBundle\Model\Auth\Controller\SecuredController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;

class LandingController extends SecuredController
{
    /**
     * @Route("/", name="landing")
     */
    public function landingAction()
    {
        if (!$this->login()) {
            $response = $this->createRedirectToLoginPageResponse();
        } else {
            $response = $this->createRedirectToFrontPageResponse();
        }

        return $response;
    }

    /**
     * @Route("/welcome/", name="welcome")
     * @Template("OmtTodoBundle:landing:welcome.html.twig")
     */
    public function welcomeAction()
    {
        if ($this->login()) {
            $response = $this->createRedirectToFrontPageResponse();
        } else {
            $response = array(
                'registerForm' => $this->createRegisterForm()->createView()
            );
        }

        return $response;
    }

    /**
     * @return Form
     */
    private function createRegisterForm()
    {
        return $this->createForm(new RegisterType(), array(), array(
            'action' => $this->generateUrl('auth_standard_register'),
            'method' => 'POST'
        ));
    }

}
