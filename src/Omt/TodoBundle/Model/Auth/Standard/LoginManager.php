<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Standard;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\SecurityBundle\Model\Password\Password;
use Omt\ContactsBundle\Model\EmailAddress;
use Omt\TodoBundle\Entity\User;
use Omt\TodoBundle\Entity\UserSession;
use Omt\TodoBundle\Model\Auth\Token\Persister\TokenPersisterInterface;

/**
 * Login manager
 */
class LoginManager
{

    const ERROR_EMAIL_NOT_FOUND = 'invalid_auth_data';
    const ERROR_PASSWORD_DOES_NOT_MATCH = 'invalid_auth_data';

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var EmailAddress
     */
    private $email;

    /**
     * @var Password
     */
    private $password;

    /**
     * @var string
     */
    private $error;

    /**
     * @var User
     */
    private $user;

    /**
     * @var UserSession
     */
    private $session;

    /**
     * @var TokenPersisterInterface[]
     */
    private $tokenPersisters;

    /**
     * @param ObjectManager $om
     * @param string $email
     * @param string $password
     * @param array $tokenPersisters
     */
    public function __construct(ObjectManager $om, $email, $password, array $tokenPersisters = array())
    {
        $this->om = $om;
        $this->email = new EmailAddress($email);
        $this->password = new Password($password);
        $this->tokenPersisters = $tokenPersisters;
    }

    public function login()
    {
        $success = false;
        if ($this->validate()) {
            $this->processLogin();
            $success = true;
        }

        return $success;
    }

    /**
     * @return bool
     */
    private function validate()
    {
        $valid = false;
        if (!$this->getUser()) {
            $this->error = self::ERROR_EMAIL_NOT_FOUND;
        } elseif (!$this->validatePassword()) {
            $valid = false;
            $this->error = self::ERROR_PASSWORD_DOES_NOT_MATCH;
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @return User
     */
    private function getUser()
    {
        if ($this->user === null) {
            $this->user = $this->om->getRepository('OmtTodoBundle:User')->findOneBy(array('email' => $this->email));
        }

        return $this->user;
    }

    /**
     * @return bool
     */
    private function validatePassword()
    {
        return $this->getUser()->getPasswordHash()->check($this->password);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    private function processLogin()
    {
        $session = new UserSession();
        $session->setUser($this->getUser());
        $this->om->persist($session);
        $this->om->flush();
        $this->session = $session;
        $this->persistToken();
    }

    private function persistToken()
    {
        foreach ($this->tokenPersisters as $persister) {
            $persister->persist($this->session->getToken());
        }
    }

}