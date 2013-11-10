<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\ContactsBundle\Model;

/**
 * Email address
 */
class EmailAddress
{

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @param string $emailAddress
     */
    public function __construct($emailAddress)
    {
        $this->emailAddress = (string)$emailAddress;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getEmailAddress();
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

}