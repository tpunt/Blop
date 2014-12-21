<?php

namespace app\models\DomainModel;

/**
 * This class encapsulates the business logic for a user.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class User
{
    /**
     * @var int|0   $userID          The ID of the user.
     * @var string| $email           The email of the user.
     * @var string| $password        The (BCrypt) hashed password of the user.
     * @var string| $forename        The forename of the user.
     * @var string| $surname         The surname of the user.
     * @var int|2   $privilegeLevel  The privilege level of the user.
     * @var array|  $addresses       The addresses of the user.
     */
    private $userID = 0,
            $email = '',
            $password = '',
            $forename = '',
            $surname = '',
            $privilegeLevel = 2,
            $addresses = [];

    /**
     * Validates and sets the forename, surname, and email of the user to instance variables.
     *
     * @param  string $forename          The forename of the user.
     * @param  string $surname           The surname of the user.
     * @param  string $email             The email of the user.
     * @throws InvalidArgumentException  Thrown if either the forename, surname, or email is invalid.
     */
    public function __construct($forename, $surname, $email)
    {
        $this->setForename($forename)->setSurname($surname)->setEmail($email);
    }

    /**
     * Validates and sets the user ID to an instance variable.
     *
     * @throws InvalidArgumentException  Thrown if the user ID is invalid.
     * @return User                      The current instance.
     */
    public function setUserID($userID)
    {
        if($userID < 1)
            throw new \InvalidArgumentException('The user ID is invalid.');

        $this->userID = $userID;
        return $this;
    }

    /**
     * Validates and sets the email to an instance variable.
     *
     * @param  string $email             The email of the user.
     * @throws InvalidArgumentException  Thrown if the email is invalid.
     * @return User                      The current instance.
     */
    public function setEmail($email)
    {
        if(filter_var($email, \FILTER_VALIDATE_EMAIL) === false)
            throw new \InvalidArgumentException('The email entered is invalid.');

        $this->email = $email;
        return $this;
    }

    /**
     * Validates and sets the (BCrypt) hashed password to an instance variable.
     *
     * @param  string $password          The (BCrypt) hashed password of the user.
     * @throws InvalidArgumentException  Thrown if the hashed password length is invalid.
     * @return User                      The current instance.
     */
    public function setPassword($password)
    {
        if(strlen($password) !== 60)
            throw new \InvalidArgumentException('The password length is invalid.');

        $this->password = $password;
        return $this;
    }

    /**
     * Sets a user's forename to an instance variable.
     *
     * @param  string $forename  The forename of the user.
     * @return User              The current instance.
     */
    public function setForename($forename)
    {
        $this->forename = $forename;
        return $this;
    }

    /**
     * Sets a user's surname to an instance variable.
     *
     * @param  string $surname  The surname of the user.
     * @return User             The current instance.
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * Sets a user's privilege level to an instance variable.
     *
     * @param  int $privilegeLevel  The privilege level of the user.
     * @return User                 The current instance.
     */
    public function setPrivilegeLevel($privilegeLevel)
    {
        $this->privilegeLevel = $privilegeLevel;
        return $this;
    }

    /**
     * Adds an address to the User object.
     *
     * @param Address $address  An Address object containing information about one address.
     */
    public function addAddress(Address $address)
    {
        array_push($this->addresses, $address);
    }

    use MagicGetter;
}