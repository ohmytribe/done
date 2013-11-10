<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Exception;

/**
 * Token expired exception
 */
class TokenExpiredException extends AccessDeniedException
{

    const MESSAGE = 'token_expired';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 403);
    }

} 