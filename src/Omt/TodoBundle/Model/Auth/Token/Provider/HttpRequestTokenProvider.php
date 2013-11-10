<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token\Provider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Http request token provider
 */
class HttpRequestTokenProvider implements TokenProviderInterface
{

    const TOKEN_REQUEST_PARAMETER_NAME = '_token';

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
        return $this->request->get(self::TOKEN_REQUEST_PARAMETER_NAME);
    }

} 