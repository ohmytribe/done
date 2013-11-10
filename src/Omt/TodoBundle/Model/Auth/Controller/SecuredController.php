<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Controller;

use Omt\TodoBundle\Model\Auth\Exception\AccessDeniedException;
use Omt\TodoBundle\Model\Auth\Token\LoginManager;
use Omt\TodoBundle\Model\Auth\Token\Provider\CookieTokenProvider;
use Omt\TodoBundle\Model\Auth\Token\Provider\HttpRequestTokenProvider;
use Omt\TodoBundle\Model\Response\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Omt\TodoBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Omt\TodoBundle\Entity\UserSession;

/**
 * Secured controller
 */
class SecuredController extends Controller
{

    const LOGIN_PAGE_NAME = 'welcome';
    const FRONT_PAGE_NAME = 'todo_list';
    const AUTH_NEEDED_ERROR_MESSAGE = 'auth_failed';

    /**
     * @var UserSession
     */
    private $session;

    /**
     * @return User
     */
    public function getUser()
    {
        if ($this->session) {
            $user = $this->session->getUser();
        } else {
            $user = null;
        }

        return $user;
    }

    /**
     * @return UserSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return bool
     */
    protected function login()
    {
        /**
         * @var ObjectManager $om
         */
        $om = $this->getDoctrine()->getManager();
        try {
            $loginManager = new LoginManager($om, array(
                new HttpRequestTokenProvider($this->getRequest()),
                new CookieTokenProvider($this->getRequest())
            ));
            $this->session = $loginManager->getSession();
            $success = true;
        } catch (AccessDeniedException $e) {
            $success = false;
        }

        return $success;
    }

    /**
     * @return RedirectResponse
     */
    protected function createRedirectToLoginPageResponse()
    {
        return $this->redirect($this->generateUrl(self::LOGIN_PAGE_NAME));
    }

    /**
     * @return RedirectResponse
     */
    protected function createRedirectToFrontPageResponse()
    {
        return $this->redirect($this->generateUrl(self::FRONT_PAGE_NAME));
    }

    /**
     * @return JsonResponse
     */
    protected function createAuthNeededJsonResponse()
    {
        return JsonResponse::createErrorResponse(self::AUTH_NEEDED_ERROR_MESSAGE);
    }

} 