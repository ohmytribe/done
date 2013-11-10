<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Standard;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\ContactsBundle\Model\EmailAddress;
use Omt\SecurityBundle\Model\Password\Password;
use Omt\TodoBundle\Entity\User;

/**
 * Registration validator
 */
class RegistrationManager
{

    const ERROR_EMAIL_ALREADY_TAKEN = 'email_already_taken';

    /**
     * @var string
     */
    private $error;

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var LoginManager
     */
    private $loginManager;

    /**
     * @param ObjectManager $om
     * @param string $email
     * @param string $password
     * @param LoginManager $loginManager
     */
    public function __construct(ObjectManager $om, $email, $password, LoginManager $loginManager = null)
    {
        $this->om = $om;
        $this->email = new EmailAddress($email);
        $this->password = new Password($password);
        $this->loginManager = $loginManager;
    }

    /**
     * @return bool
     */
    public function register()
    {
        if ($this->validate()) {
            $this->createUser();
            if (!$this->login()) {
                $success = false;
            } else {
                $success = true;
            }
        } else {
            $success = false;
        }

        return $success;
    }

    /**
     * @return bool
     */
    private function validate()
    {
        $valid = true;
        if ($this->emailExists()) {
            $this->error = self::ERROR_EMAIL_ALREADY_TAKEN;
            $valid = false;
        }

        return $valid;
    }

    /**
     * @return bool
     */
    private function emailExists()
    {
        return (bool)$this->om->getRepository('OmtTodoBundle:User')->findOneBy(array('email' => $this->email));
    }

    private function createUser()
    {
        $user = new User();
        $user->setEmail($this->email);
        $user->setPassword($this->password);
        $this->om->persist($user);
        $this->om->flush();
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    private function login()
    {
        $success = true;
        if ($this->loginManager !== null) {
            if (!$this->loginManager->login()) {
                $success = false;
                $this->error = $this->loginManager->getError();
            }
        }

        return $success;
    }

}