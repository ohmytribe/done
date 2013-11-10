<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Auth\Token;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\TodoBundle\Entity\UserSession;
use Omt\TodoBundle\Entity\User;
use Omt\TodoBundle\Model\Auth\Exception\InvalidTokenException;
use Omt\TodoBundle\Model\Auth\Exception\TokenExpiredException;
use Omt\TodoBundle\Model\Auth\Token\Provider\TokenProviderInterface;

/**
 * Token auth login manager
 */
class LoginManager
{

    /**
     * @var TokenProviderInterface[]
     */
    private $tokenProviders;

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     * @param TokenProviderInterface[] $tokenProviders List of token providers in priority order
     */
    public function __construct(ObjectManager $om, array $tokenProviders)
    {
        $this->om = $om;
        $this->tokenProviders = $tokenProviders;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        $token = null;
        foreach ($this->tokenProviders as $tokenProvider) {
            $providerToken = $tokenProvider->getToken();
            if ($providerToken !== null) {
                $token = $providerToken;
                break;
            }
        }

        return $token;
    }

    /**
     * @return UserSession
     * @throws \Omt\TodoBundle\Model\Auth\Exception\InvalidTokenException if token is not found
     * @throws \Omt\TodoBundle\Model\Auth\Exception\TokenExpiredException if token is not active
     */
    public function getSession()
    {
        $token = $this->getToken();
        if (!$token) {
            throw new InvalidTokenException();
        }
        /**
         * @var UserSession $session
         */
        $session = $this->om->getRepository('OmtTodoBundle:UserSession')->findOneBy(array(
            'token' => $token));
        if ($session === null) {
            throw new InvalidTokenException();
        } elseif (!$session->getIsActive()) {
            throw new TokenExpiredException();
        }

        return $session;
    }

} 