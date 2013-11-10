<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token\Persister;

/**
 * Token persister interface
 */
interface TokenPersisterInterface
{

    /**
     * @param string $token
     */
    public function persist($token);

    public function remove();

} 