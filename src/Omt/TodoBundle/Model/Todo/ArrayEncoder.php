<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Todo;

use Doctrine\Common\Persistence\ObjectManager;
use Omt\TodoBundle\Entity\Todo;
use Omt\TodoBundle\Entity\User;

/**
 * To-do encoder
 */
class ArrayEncoder
{

    const ID_FIELD_NAME = 'id';
    const TASK_FIELD_NAME = 'task';
    const PRIORITY_FIELD_NAME = 'priority';
    const IS_DONE_FIELD_NAME = 'isDone';

    /**
     * @param Todo $todo
     * @return array
     */
    public static function encode(Todo $todo)
    {
        return array(
            self::ID_FIELD_NAME => $todo->getId(),
            self::TASK_FIELD_NAME => $todo->getTask(),
            self::PRIORITY_FIELD_NAME => $todo->getPriority(),
            self::IS_DONE_FIELD_NAME => $todo->getIsDone()
        );
    }

    /**
     * @param Todo[] $todos
     * @return array
     */
    public static function encodeList($todos)
    {
        $encoded = array();
        foreach ($todos as $todo) {
            $encoded[] = self::encode($todo);
        }

        return $encoded;
    }

} 