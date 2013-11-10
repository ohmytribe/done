<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token\Provider;

use Omt\TodoBundle\Model\Auth\Token\Persister\CookieTokenPersister;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cookie token provider
 */
class CookieTokenProvider implements TokenProviderInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->request->cookies->get(CookieTokenPersister::COOKIE_PARAMETER_NAME);
    }

} 