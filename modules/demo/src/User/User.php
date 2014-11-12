<?php  namespace Drupal\demo\User; 

use Drupal\demo\ValueObject\Name;
use Drupal\user\Entity\User as DrupalUser;

class User extends DrupalUser
{
    /**
     * @var Name
     */
    private $name;

    /**
     * @param Name $name
     */
    public function __construct(Name $name) {
        $this->setUsername($name);
        $this->name = $name;
    }

    /**
     * @param Name $name
     */
    public function changeName(Name $name) {
        $this->setUsername($name);
    }
} 
