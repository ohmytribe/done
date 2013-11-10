<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token\Persister;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cookie token persister
 */
class CookieTokenPersister implements TokenPersisterInterface
{

    const COOKIE_PARAMETER_NAME = 'auth_token';

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param string $token
     */
    public function persist($token)
    {
        $cookie = new Cookie(self::COOKIE_PARAMETER_NAME, $token);
        $this->response->headers->setCookie($cookie);
    }

    public function remove()
    {
        $cookie = new Cookie(self::COOKIE_PARAMETER_NAME, null, new \DateTime('-1 year'));
        $this->response->headers->setCookie($cookie);
    }

} 