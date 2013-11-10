<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * To-do
 *
 * @ORM\Table(name="todo",
 *     indexes={
 *         @ORM\Index(name="user_todo_priority_idx", columns={"user_id", "priority", "is_done"})
 *     }
 * )
 * @ORM\Entity
 */
class Todo
{

    /**
     * @var array
     */
    private $possiblePriorities = array(
        'high' => 2,
        'medium' => 1,
        'low' => 0
    );

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
     * @ORM\Column(name="task", type="string", nullable=false)
     */
    private $task;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_done", type="boolean", nullable=false)
     */
    private $isDone = false;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     **/
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @param boolean $isDone
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    }

    /**
     * @return boolean
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * @param string $priority
     * @throws \InvalidArgumentException if given priority is not supported.
     */
    public function setPriority($priority)
    {
        if (!array_key_exists($priority, $this->possiblePriorities)) {
            throw new \InvalidArgumentException('Unknown priority [' . $priority . '].');
        }
        $this->priority = $this->possiblePriorities[$priority];
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        $priority = null;
        foreach ($this->possiblePriorities as $name => $value) {
            if ($value == $this->priority) {
                $priority = $name;
            }
        }

        return $priority;
    }

    /**
     * @param string $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

}
