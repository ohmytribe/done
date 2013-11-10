<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\SecurityBundle\Model\Password;
use Omt\SecurityBundle\Model\Token\UniqidBasedToken;

/**
 * Password encryptor
 */
class Encryptor
{

    /**
     * @see http://php.net/manual/en/function.mcrypt-create-iv.php
     */
    const SALT_SIZE = 32;

    /**
     * @see http://php.net/manual/en/crypt.php CRYPT_SHA512 section
     */
    const HASHING_ROUNDS = 300000;

    /**
     * @param Password $password
     * @param Hash $hash generate hash using the same salt that given hash was generated with.
     * @return Hash
     */
    public static function encrypt(Password $password, Hash $hash = null)
    {
        if ($hash === null) {
            $salt = '$6$rounds=' . self::HASHING_ROUNDS
                . '$' . self::generateSalt() . '$';
        } else {
            $salt = $hash->getHash();
        }
        $hash = crypt($password->getPassword(), $salt);

        return new Hash($hash);
    }

    /**
     * @return string
     */
    private static function generateSalt()
    {
        return UniqidBasedToken::create()->getToken();
    }

}