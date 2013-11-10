<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\SecurityBundle\Model\Password;

/**
 * Password
 */
class Password
{

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $password
     * @throws \InvalidArgumentException if empty password provided.
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return Hash
     */
    public function encrypt()
    {
        return Encryptor::encrypt($this);
    }

}