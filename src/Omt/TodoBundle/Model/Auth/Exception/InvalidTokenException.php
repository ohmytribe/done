<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Exception;

/**
 * Invalid token exception
 */
class InvalidTokenException extends AccessDeniedException
{

    const MESSAGE = 'invalid_token';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 403);
    }

} 