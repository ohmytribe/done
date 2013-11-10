<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token\Provider;

/**
 * Token provider interface
 */
interface TokenProviderInterface
{

    /**
     * @return string
     */
    public function getToken();

} 