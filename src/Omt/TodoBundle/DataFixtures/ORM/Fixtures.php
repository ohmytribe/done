<?php

/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Omt\TodoBundle\Entity\User;
use Omt\TodoBundle\Entity\Todo;
use Omt\ContactsBundle\Model\EmailAddress;
use Omt\SecurityBundle\Model\Password\Password;

/**
 * Fixtures
 */
class Fixtures implements FixtureInterface
{

    const DEMO_EMAIL = 'demo@demo.demo';
    const DEMO_PASSWORD = 'demo';

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->om = $manager;
        $this->loadUser();
    }

    private function loadUser()
    {
        $user = new User();
        $user->setEmail(new EmailAddress(self::DEMO_EMAIL));
        $user->setPassword(new Password(self::DEMO_PASSWORD));
        $this->om->persist($user);
        $this->loadTodos($user);
        $this->om->flush();
    }

    /**
     * @param User $user
     */
    private function loadTodos(User $user)
    {
        $todos = array(
            'Brush teeth' => 'high',
            'Drink coffee' => 'high',
            'Check Facebook' => 'high',
            'Eat sandwich' => 'medium',
            'Check mail' => 'medium',
            'Go to work' => 'low',
            'Take kids from school' => 'low',
        );
        foreach ($todos as $task => $priority) {
            $todo = new Todo();
            $todo->setTask($task);
            $todo->setPriority($priority);
            $todo->setUser($user);
            $this->om->persist($todo);
        }
    }

}