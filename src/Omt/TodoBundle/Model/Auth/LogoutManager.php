<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\TodoBundle\Model\Auth\Token\Persister\TokenPersisterInterface;
use Omt\TodoBundle\Entity\UserSession;

/**
 * Login manager
 */
class LogoutManager
{

    /**
     * @var ObjectManager
     */
    private $om;

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
     * @param UserSession $session
     * @param array $tokenPersisters
     */
    public function __construct(ObjectManager $om, UserSession $session, array $tokenPersisters = array())
    {
        $this->om = $om;
        $this->session = $session;
        $this->tokenPersisters = $tokenPersisters;
    }

    public function logout()
    {
        $this->session->close();
        $this->om->persist($this->session);
        $this->om->flush();
        $this->removeToken();
    }

    private function removeToken()
    {
        foreach ($this->tokenPersisters as $persister) {
            $persister->remove();
        }
    }

}