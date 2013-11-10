<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Todo;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\TodoBundle\Entity\Todo;
use Omt\TodoBundle\Entity\User;

/**
 * To-do validator
 */
class Validator
{

    const TASK_IS_NOT_SET_ERROR = 'task_is_not_defined';
    const PRIORITY_IS_NOT_SET_ERROR = 'priority_is_not_defined';
    const INVALID_PRIORITY_ERROR = 'invalid_priority_provided';

    /**
     * @var array
     */
    private $validPriorities = array('high', 'medium', 'low');

    /**
     * @var string
     */
    private $task;

    /**
     * @var string
     */
    private $priority;

    /**
     * @var bool
     */
    private $filledOnly;

    /**
     * @var string
     */
    private $error;

    /**
     * @param string $task
     * @param string $priority
     * @param bool $filledOnly
     */
    public function __construct($task, $priority, $filledOnly)
    {
        $this->task = $task;
        $this->priority = $priority;
        $this->filledOnly = $filledOnly;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $valid = true;
        if (($this->filledOnly && $this->task !== null || !$this->filledOnly)) {
            if (!$this->validateTask()) {
                $valid = false;
            }
        }
        if ($valid
            && ($this->filledOnly && $this->priority !== null || !$this->filledOnly)) {
            if (!$this->validatePriority()) {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * @return bool
     */
    private function validateTask()
    {
        if (empty($this->task)) {
            $this->error = self::TASK_IS_NOT_SET_ERROR;
            $valid = false;
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @return bool
     */
    private function validatePriority()
    {
        if (empty($this->priority)) {
            $this->error = self::PRIORITY_IS_NOT_SET_ERROR;
            $valid = false;
        } elseif (!in_array($this->priority, $this->validPriorities)) {
            $this->error = self::INVALID_PRIORITY_ERROR;
            $valid = false;
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

} 