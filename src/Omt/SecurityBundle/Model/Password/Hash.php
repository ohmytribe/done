<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\SecurityBundle\Model\Password;

/**
 * Password hash
 */
class Hash
{

    /**
     * @var string
     */
    private $hash;

    /**
     * @param string $hash
     */
    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param Password $password
     * @return bool
     */
    public function check(Password $password)
    {
        return (Encryptor::encrypt($password, $this)->getHash() === $this->getHash());
    }

}