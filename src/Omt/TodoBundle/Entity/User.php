<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Omt\SecurityBundle\Model\Password\Password;
use Omt\SecurityBundle\Model\Password\Hash;

/**
 * User
 *
 * @ORM\Table(name="users",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="user_email_idx", columns={"email"})
 *     }
 * )
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="email", type="emailaddress", nullable=false)
     */
    private $email;

    /**
     * @var Hash
     *
     * @ORM\Column(name="password", type="password", nullable=false)
     */
    private $passwordHash;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Password $password
     */
    public function setPassword(Password $password)
    {
        $this->passwordHash = $password->encrypt();
    }

    /**
     * @return Hash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

}
