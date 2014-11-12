<?php  namespace Drupal\demo\User\Repository; 

use Drupal\user\Entity\User;

class ArrayUserRepository implements UserRepository
{
    /**
     * @var array
     */
    private $storage = array();

    /**
     * @param User $user
     */
    public function add(User $user) {
        $this->storage[$user->id()] = $user;
    }

    /**
     * @param User $user
     */
    public function remove(User $user) {
        unset($this->storage[$user->id()]);
    }

    /**
     * @return User[] $users
     */
    public function getAll() {
        return $this->storage;
    }

    /**
     * @param int $id
     * @return User|false $user
     */
    public function getFromId($id) {
        return isset($this->storage[$id]) ? $this->storage[$id] : false;
    }
} 
