<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Todo;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\TodoBundle\Entity\User;
use Omt\TodoBundle\Entity\Todo;

/**
 * To-do list manager
 */
class Manager
{

    const DEFAULT_COUNT = 10;

    const NOT_FOUND_ERROR = 'not_found';

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $error;

    /**
     * @param ObjectManager $om
     * @param User $user
     */
    public function __construct(ObjectManager $om, User $user)
    {
        $this->om = $om;
        $this->user = $user;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getRepository()
    {
        return $this->om->getRepository('OmtTodoBundle:Todo');
    }

    /**
     * @param int $id
     * @return Todo|null
     */
    public function get($id)
    {
        $todo = $this->getRepository()->findOneBy(array('id' => $id, 'user' => $this->user));
        if (!$todo) {
            $this->error = self::NOT_FOUND_ERROR;
        }

        return $todo;
    }

    /**
     * TODO: Support pagination.
     * @return Todo[]
     */
    public function getList()
    {
        return $this->getRepository()
            ->findBy(array('user' => $this->user), array('isDone' => 'asc', 'priority' => 'desc'));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function markDone($id)
    {
        $todo = $this->get($id);
        if ($todo) {
            $todo->setIsDone(true);
            $this->om->persist($todo);
            $this->om->flush();
            $success = true;
        } else {
            $success = false;
        }

        return $success;
    }

    /**
     * @param int $id
     * @param string $task
     * @param string $priority
     * @return bool
     */
    public function modify($id, $task = null, $priority = null)
    {
        if ($this->validate($task, $priority, true)) {
            $todo = $this->get($id);
            if ($todo) {
                if ($task !== null) {
                    $todo->setTask($task);
                }
                if ($priority !== null) {
                    $todo->setPriority($priority);
                }
                $this->om->persist($todo);
                $this->om->flush();
                $success = true;
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }

        return $success;
    }

    /**
     * @param string $task
     * @param string $priority
     * @return bool
     */
    public function create($task, $priority)
    {
        if ($this->validate($task, $priority, false)) {
            $todo = new Todo();
            $todo->setTask($task);
            $todo->setPriority($priority);
            $todo->setUser($this->user);
            $this->om->persist($todo);
            $this->om->flush();
            $success = true;
        } else {
            $success = false;
        }


        return $success;
    }

    /**
     * @param string $task
     * @param string $priority
     * @param bool $filledOnly
     * @return bool
     */
    private function validate($task, $priority, $filledOnly)
    {
        $validator = new Validator($task, $priority, $filledOnly);
        if (!$validator->validate()) {
            $this->error = $validator->getError();
            $valid = false;
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function remove($id)
    {
        $todo = $this->get($id);
        if ($todo) {
            $this->om->remove($todo);
            $this->om->flush();
            $success = true;
        } else {
            $success = false;
        }

        return $success;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}