<?php

namespace Drupal\demo\User\Repository;

use Drupal\user\Entity\User;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user);

    /**
     * @param User $user
     */
    public function remove(User $user);

    /**
     * @return User[] $users
     */
    public function getAll();

    /**
     * @param int $id
     * @return User $user
     */
    public function getFromId($id);
}
