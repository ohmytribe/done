<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Exception;

/**
 * Access denied exception
 */
class AccessDeniedException extends \Exception
{

    const MESSAGE = 'access_denied';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, 403);
    }

} 