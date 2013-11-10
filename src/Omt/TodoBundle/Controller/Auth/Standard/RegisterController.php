<?php

namespace Omt\TodoBundle\Controller\Auth\Standard;

use Omt\TodoBundle\Form\Type\RegisterType;
use Omt\TodoBundle\Model\Auth\Standard\RegistrationManager;
use Omt\TodoBundle\Model\Auth\Standard\LoginManager;
use Omt\TodoBundle\Model\Auth\Token\Persister\CookieTokenPersister;
use Omt\TodoBundle\Model\Auth\Token\Persister\JsonResponseTokenPersister;
use Omt\TodoBundle\Model\Form\FormRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Omt\TodoBundle\Model\Response\JsonResponse;

/**
 * @Route("/auth/standard/register")
 */
class RegisterController extends Controller
{

    const SUCCESS_MESSAGE = 'signed_up';

    /**
     * @Route("/", name="auth_standard_register")
     * @Method({"POST"})
     */
    public function registerAction()
    {
        $form = $this->createForm(new RegisterType());
        $formValidator = new FormRequestValidator();
        $response = JsonResponse::createSuccessResponse(self::SUCCESS_MESSAGE);
        if (!$formValidator->validate($form, $this->getRequest())) {
            $success = false;
            $message = $formValidator->getError();
        } else {
            $formData = $form->getData();
            $registerManager = $this->createRegistrationManager($response, $formData['email'], $formData['password']);
            if (!$registerManager->register()) {
                $success = false;
                $message = $registerManager->getError();
            } else {
                $success = true;
                $message = false;
            }
        }

        if (!$success) {
            $response = JsonResponse::createErrorResponse($message);
        }

        return $response;
    }

    /**
     * @param JsonResponse $response
     * @param string $email
     * @param string $password
     * @return RegistrationManager
     */
    public function createRegistrationManager(JsonResponse $response, $email, $password)
    {
        $loginManager = $this->createLoginManager($response, $email, $password);

        return new RegistrationManager($this->getDoctrine()->getManager(), $email, $password, $loginManager);
    }

    /**
     * @param JsonResponse $response
     * @param string $email
     * @param string $password
     * @return LoginManager
     */
    private function createLoginManager(JsonResponse $response, $email, $password)
    {
        return new LoginManager($this->getDoctrine()->getManager(), $email, $password, array(
            new CookieTokenPersister($response),
            new JsonResponseTokenPersister($response)));
    }

}