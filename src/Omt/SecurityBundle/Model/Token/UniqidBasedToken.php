<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\SecurityBundle\Model\Token;

/**
 * Uniqid based token
 */
class UniqidBasedToken
{

    /**
     * @var string
     */
    private $token;

    /**
     * @param string $prefix
     * @return UniqidBasedToken
     */
    public static function create($prefix = null)
    {
        return new self($prefix);
    }

    /**
     * @param string $prefix
     */
    public function __construct($prefix = null)
    {
        $this->token = $this->generateToken($prefix);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $prefix
     * @return string
     */
    private function generateToken($prefix)
    {
        $token = uniqid();
        if ($prefix) {
            $token = $prefix . $token;
        }

        return $token;
    }

} 