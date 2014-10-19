<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\User as User;

/**
 * This class handles users and their information.
 *
 * It both hydrates the User domain model object from the DB to be sent to the corresponding
 * view, and persists the User object to the database.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class UserMapper
{
    /**
     * @var PDO|null $pdo    The PDO object.
     * @var string|  $error  The error string if an error occurrs.
     */
    private $pdo = null,
            $error = '';

    /**
     * Sets the PDO object to an instance variable.
     *
     * @param PDO $pdo  The PDO object.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Validates a user's login credentials.
     *
     * An InvalidArgumentException is thrown if the POST data is empty or it has unset missing
     * form fields. The reason why an error is not being returned is because the form isn't being
     * being properly submitted. For example, the by visiting the URI http://domain.com/login/validateLogin,
     * if an error was to be returned, then it would seem like the semantics of the form would be via the
     * HTTP GET method (i.e. the form data is passed via a query string in the URI). This is not the semantics
     * that should be associated to a login form since sensitive data is being passed into the web application.
     * An exception is therefore thrown to be handled up the call stack, where a redirect is performed to the
     * route name that the action was attempted to be called on.
     *
     * If any data fails the validation process, and error is set and the method short-circuits with a void return.
     *
     * @param array $postData   The $_POST data
     * @throws InvalidArgumentException Thrown if incomplete or non-existent POST dasta is given
     */
    public function validateUserLogin(array $postData) // This doesn't really relate to the UserMapper (i.e. it does not map anything to/from User)
    {
        if(empty($postData) || !isset($postData['email'], $postData['pws']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        if(empty($postData['email']) || empty($postData['pws'])) {
            $this->error = 'Email and/or password are empty.';
            return;
        }

        $validUser = $this->pdo->prepare('SELECT user_id, password FROM Users WHERE email = ?');
        $validUser->execute([$postData['email']]);

        if(!$user = $validUser->fetch(\PDO::FETCH_ASSOC)) {
            $this->error = 'Them email is invalid.';
            return;
        }

        if(password_verify($postData['pws'], $user['password'])) {
            $_SESSION['user'] = ['user_id' => (int) $user['user_id']];
            header('Location: http://lindseyspt.pro'); // remember to make the domain name a variable
            die;
        }

        $this->error = 'Your password is incorrect.';
    }

    /**
     * Validates the user's registration information.
     *
     * Again, this method has the same semantics as the validateUserLogin method.
     *
     * @param array $postData   The $_POST data
     * @throws InvalidArgumentException Thrown if incomplete or non-existent POST data or if invalid form data is given
     */
    public function validateUserRegistration(array $postData)
    {
        if(empty($postData) || !isset($postData['forename'], $postData['surname'], $postData['email'], $postData['pws'], $postData['rpws']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        if(empty($postData['forename']) || empty($postData['surname']) || empty($postData['email']) || empty($postData['pws']) || empty($postData['rpws'])) {
            $this->error = 'No fields should be empty.';
            return;
        }

        if($postData['pws'] !== $postData['rpws']) {
            $this->error = 'Your passwords do not match.';
            return;
        }

        // should I perform an email check here, or just try to insert the user and catch a PDO error for a duplicate insertion in the email field?
        //$emailCheck = $this->pdo->prepare('SELECT COUNT(*) FROM Users WHERE email = ?');

        //    $postData['email'];

        try {
            $user = new User($postData['forename'], $postData['surname'], $postData['email']);

            $pwsOptions = ['cost' => 7,
                           'salt' => bin2hex(openssl_random_pseudo_bytes(22))];

            $pwsHash = password_hash($postData['pws'], \PASSWORD_BCRYPT, $pwsOptions);
            $user->setpassword($pwsHash);
        }catch(\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            return;
        }

        try {
            $userID = $this->insertUser($user);
        }catch(\PDOException $e) {
            $this->error = 'The email is already registered with us.';
            return;
        }

        $_SESSION['user'] = ['user_id' => $userID];
        header('Location: http://lindseyspt.pro'); //remember to make the domain name a variable
        die;
    }

    /**
     * Simple return the error instance variable.
     *
     * @return string   The error message or an empty string if no error occurred
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Insert a user from the User domain object.
     *
     * @return int  the ID of the user that has just been inserted
     */
    private function insertUser(User $user)
    {
        $userQuery = $this->pdo->prepare('INSERT INTO Users VALUES (NULL, :email, :pws, :forename, :surname, :privilege)');
        $userQuery->bindValue('email', $user->getEmail());
        $userQuery->bindValue('pws', $user->getPassword());
        $userQuery->bindValue('forename', $user->getForename());
        $userQuery->bindValue('surname', $user->getSurname());
        $userQuery->bindValue('privilege', $user->getPrivilegeLevel(), \PDO::PARAM_INT);
        $userQuery->execute();

        return (int) $this->pdo->lastInsertId();

        // should I catch an error and return a bool, or just let an exception bubble up the call stack and catch it there?
    }
}