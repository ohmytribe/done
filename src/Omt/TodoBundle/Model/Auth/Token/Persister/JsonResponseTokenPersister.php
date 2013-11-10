<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token\Persister;

use Omt\TodoBundle\Model\Response\JsonResponse;

/**
 * Json response token persister
 */
class JsonResponseTokenPersister implements TokenPersisterInterface
{

    const TOKEN_PARAMETER_NAME = '_token';

    /**
     * @var JsonResponse
     */
    private $response;

    /**
     * @param JsonResponse $response
     */
    public function __construct(JsonResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @param string $token
     */
    public function persist($token)
    {
        $this->response->addData(self::TOKEN_PARAMETER_NAME, $token);
    }

    public function remove()
    { }

} 