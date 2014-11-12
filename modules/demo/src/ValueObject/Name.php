<?php  namespace Drupal\demo\ValueObject; 

class Name
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param $firstName
     * @param $lastName
     * @throws InvalidArgumentException
     */
    public function __construct($firstName, $lastName) {
        if (empty($firstName)) {
            throw new InvalidArgumentException('First name can not be empty.');
        }

        if (empty($firstName)) {
            throw new InvalidArgumentException('Last name can not be empty.');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Returns the full name as a string
     *
     * @return string $name
     */
    public function __toString() {
        return $this->firstName . ' ' . $this->lastName;
    }
} 
