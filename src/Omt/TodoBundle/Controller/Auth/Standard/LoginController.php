<?php

namespace Omt\TodoBundle\Controller\Auth\Standard;

use Omt\TodoBundle\Model\Auth\Standard\LoginManager;
use Omt\TodoBundle\Model\Auth\Token\Persister\CookieTokenPersister;
use Omt\TodoBundle\Model\Auth\Token\Persister\JsonResponseTokenPersister;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Omt\TodoBundle\Model\Response\JsonResponse;

/**
 * @Route("/auth/standard/login")
 */
class LoginController extends Controller
{

    const SUCCESS_MESSAGE = 'signed_in';
    const INVALID_REQUEST_DATA_ERROR_MESSAGE = 'invalid_request_data';

    const REQUEST_PARAMETER_EMAIL = 'email';
    const REQUEST_PARAMETER_PASSWORD = 'password';

    /**
     * @Route("/", name="auth_standard_login")
     * @Method({"POST"})
     */
    public function loginAction()
    {
        $response = JsonResponse::createSuccessResponse(self::SUCCESS_MESSAGE);
        $loginManager = $this->createLoginManager($response);
        if (!$loginManager->login()) {
            $response = JsonResponse::createErrorResponse($loginManager->getError());
        }

        return $response;
    }

    /**
     * @param JsonResponse $response
     * @return LoginManager
     */
    private function createLoginManager(JsonResponse $response)
    {
        $email = $this->getRequest()->get(self::REQUEST_PARAMETER_EMAIL);
        $password = $this->getRequest()->get(self::REQUEST_PARAMETER_PASSWORD);

        return new LoginManager($this->getDoctrine()->getManager(), $email, $password, array(
            new CookieTokenPersister($response),
            new JsonResponseTokenPersister($response)));
    }

}