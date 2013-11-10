<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\SecurityBundle\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BlobType;
use Omt\SecurityBundle\Model\Password\Hash;

/**
 * Password type
 */
class PasswordType extends BlobType
{

    const NAME = 'password';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Hash
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Hash(base64_decode($value));
    }

    /**
     * @param Hash $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return base64_encode($value->getHash());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

}