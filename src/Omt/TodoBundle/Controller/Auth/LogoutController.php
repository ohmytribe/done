<?php

namespace Omt\TodoBundle\Controller\Auth;

use Omt\TodoBundle\Model\Auth\Controller\SecuredController;
use Omt\TodoBundle\Model\Auth\LogoutManager;
use Omt\TodoBundle\Model\Auth\Token\Persister\CookieTokenPersister;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/auth/logout")
 */
class LogoutController extends SecuredController
{

    /**
     * @Route("/", name="auth_logout")
     * @Method({"GET"})
     */
    public function logoutAction()
    {
        $response = $this->createRedirectToLoginPageResponse();
        if ($this->login()) {
            $this->createLogoutManager($response)->logout();
        }

        return $response;
    }

    /**
     * @param Response $response
     * @return LogoutManager
     */
    private function createLogoutManager(Response $response)
    {
        return new LogoutManager($this->getDoctrine()->getManager(), $this->getSession(), array(
            new CookieTokenPersister($response)
        ));
    }

}