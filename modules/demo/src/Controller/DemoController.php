<?php
/**
 * @file
 * Contains \Drupal\demo\Controller\DemoController.
 */

namespace Drupal\demo\Controller;

use Drupal\demo\User\Repository\UserRepository;
use Drupal\demo\User\User;
use Drupal\demo\ValueObject\Name;

class DemoController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Prints hello user message
     */
    public function helloUser($userId)
    {
        $user = $this->userRepository->getFromId($userId);

        return array(
            '#markup' => "Hello {$user->getUsername()}! This is a demo page.",
        );
    }

    /**
     * Prints hello message to all users
     */
    public function helloUsers()
    {
        $users = $this->userRepository->getAll();
        $userNames = array();

        foreach ($users as $user) {
            $userNames[] = $user->getUsername();
        }

        return array(
            '#markup' => 'Hello ' . implode(', ', $userNames) . '! This is a demo page.',
        );
    }
} 
