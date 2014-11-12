<?php

namespace Drupal\demo\User\Repository;

use Drupal\user\Entity\User;
use Drupal\user\UserStorageInterface;

class DrupalUserRepository implements UserRepository
{
    private $storage;

    public function __construct(UserStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->storage->save($user);
    }

    /**
     * @param User $user
     */
    public function remove(User $user) {
        $this->storage->delete(array($user));
    }

    public function getAll()
    {
        $userIds = $this->storage->getQuery()->execute();

        return $this->storage->loadMultiple($userIds);
    }

    public function getFromId($id)
    {
        return $this->storage->load($id);
    }
}
