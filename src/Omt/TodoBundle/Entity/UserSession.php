<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omt\SecurityBundle\Model\Token\UniqidBasedToken;

/**
 * User session
 *
 * @ORM\Table(name="user_session",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="active_user_session_token_idx", columns={"token"})
 *     }
 * )
 * @ORM\Entity
 */
class UserSession
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", nullable=false)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_at", type="datetime", nullable=false)
     */
    private $startedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closed_at", type="datetime", nullable=true)
     */
    private $closedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive = true;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     **/
    private $user;

    public function __construct()
    {
        $this->startedAt = new \DateTime();
        $this->token = $this->generateToken();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     * TODO: Use more strong token generator.
     */
    private function generateToken()
    {
        return UniqidBasedToken::create()->getToken();
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function close()
    {
        $this->isActive = false;
        $this->closedAt = new \DateTime();
    }

}
