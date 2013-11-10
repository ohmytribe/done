<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\ContactsBundle\Type;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Omt\ContactsBundle\Model\EmailAddress;

/**
 * Email address type
 */
class EmailAddressType extends StringType
{

    const NAME = 'emailaddress';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return EmailAddress
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new EmailAddress($value);
    }

    /**
     * @param EmailAddress $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getEmailAddress();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

}