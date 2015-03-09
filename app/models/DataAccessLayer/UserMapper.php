<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\User;

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
     * @var PDO|null $pdo       The PDO object
     * @var string|  $error     The error string if an error occurrs
     * @var string|  $errorTag  A way to associate something to the error that has occurred.
     *                          This is used for when multiple multiple forms exist on a single
     *                          page that can trigger their own errors (example: updateInfo.tpl)
     */
    private $pdo = null,
            $error = '',
            $errorTag = '';

    /**
     * Sets the PDO object to an instance variable.
     *
     * @param PDO $pdo  The PDO object
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
     * If any data fails the validation process, an error is set and the method short-circuits with a void return.
     *
     * @param  array $postData           The $_POST data
     * @throws InvalidArgumentException  Thrown if incomplete or non-existent POST dasta is given
     */
    public function validateUserLogin(array $postData)
    {
        if(empty($postData) || !isset($postData['email'], $postData['pws']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        if(empty($postData['email']) || empty($postData['pws'])) {
            $this->error = 'Email and/or password are empty.';
            return;
        }

        $validUser = $this->pdo->prepare('SELECT user_id, password, privilege_level FROM Users WHERE email = ?');
        $validUser->execute([$postData['email']]);

        if(!$user = $validUser->fetch(\PDO::FETCH_ASSOC)) {
            $this->error = 'The email is invalid.';
            return;
        }

        if(password_verify($postData['pws'], $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => (int) $user['user_id'],
                'pLevel' => $user['privilege_level']
            ];
            header('Location: /');
            die;
        }

        $this->error = 'Your password is incorrect.';
    }

    /**
     * Validates the user's registration information.
     *
     * Again, this method has the same semantics as the validateUserLogin method.
     *
     * @param  array $postData           The $_POST data
     * @throws InvalidArgumentException  Thrown if incomplete, invalid, or non-existent POST data is given
     */
    public function validateUserRegistration(array $postData)
    {
        if(empty($postData)
            || !isset(
                $postData['forename'],
                $postData['surname'],
                $postData['email'],
                $postData['pws'],
                $postData['rpws']
            )
        ) {
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');
        }

        if(empty($postData['forename'])
            || empty($postData['surname'])
            || empty($postData['email'])
            || empty($postData['pws'])
            || empty($postData['rpws'])
        ) {
            $this->error = 'No fields should be empty.';
            return;
        }

        if($postData['pws'] !== $postData['rpws']) {
            $this->error = 'Your passwords do not match.';
            return;
        }

        try {
            $user = new User;
            $user->setForename($postData['forename']);
            $user->setSurname($postData['surname']);
            $user->setEmail($postData['email']);
            $user->setpassword($this->hashPassword($postData['pws']));
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
        header('Location: /');
        die;
    }

    /**
     * Hashes a password using BCrypt and returns the digest.
     *
     * @param  string $password  The password in plain text form
     * @return string            The hash digest
     */
    private function hashPassword($password)
    {
        $pwsOptions = [
            'cost' => 7,
            'salt' => bin2hex(openssl_random_pseudo_bytes(22))
        ];

        return password_hash($password, \PASSWORD_BCRYPT, $pwsOptions);
    }

    /**
     * Verifies that a user's password is correct.
     *
     * This is primarily used for privileged actions, where the user must provide their password.
     *
     * @param  array $postData          The $_POST data
     * @throws InvalidArgumentException Thrown if incomplete or non-existent POST data or if invalid form data is given
     */
    private function verifyUserPassword($password, $userID)
    {
        $pwsQuery = $this->pdo->prepare('SELECT password FROM Users WHERE user_id = ?');
        $pwsQuery->execute([$userID]);

        return password_verify($password, $pwsQuery->fetch(\PDO::FETCH_ASSOC)['password']);
    }

    /**
     * Validates the user's modified information and then updates them on success.
     *
     * Again, this method has the same semantics as the validateUserLogin method.
     *
     * @param  array $postData          The $_POST data
     * @throws InvalidArgumentException Thrown if incomplete or non-existent POST data or if invalid form data is given
     */
    public function modifyUserGeneralInfo(array $postData, $userID)
    {
        if(empty($postData) || !isset($postData['forename'], $postData['surname'])) {
            throw new \InvalidArgumentException('HTTP POST data is either empty or incomplete.');
        }

        if (empty($postData['forename']) || empty($postData['surname'])) {
            $this->error = 'No fields should be empty.';
            $this->errorTag = 'updateGeneralInfo';
            return;
        }

        try {
            $user = new User($userID);
            $user->setForename($postData['forename']);
            $user->setSurname($postData['surname']);
        }catch(\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            $this->errorTag = 'updateGeneralInfo';
            return;
        }

        $this->updateUserGeneralInfo($user);

        header('Location: /account/updateInfo');
        die;
    }

    /**
     * Validates the user's modified information and then updates them on success.
     *
     * Again, this method has the same semantics as the validateUserLogin method.
     *
     * @param  array $postData          The $_POST data
     * @param  int   $userID            The ID of the user to modify
     * @throws InvalidArgumentException Thrown if incomplete or non-existent POST data or if invalid form data is given
     */
    public function modifyUserSensitiveInfo(array $postData, $userID)
    {
        if (empty($postData)
            || !isset(
                $postData['current_pws'],
                $postData['pws'],
                $postData['rpws'],
                $postData['email']
            )
        ) {
            throw new \InvalidArgumentException('HTTP POST data is either empty or incomplete.');
        }

        if (empty($postData['current_pws']) || empty($postData['email'])) {
            $this->error = 'No fields should be empty.';
            $this->errorTag = 'updateSensitiveInfo';
            return;
        }

        try {
            $user = new User($userID);
            $user->setEmail($postData['email']);
        }catch (\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            $this->errorTag = 'updateSensitiveInfo';
            return;
        }

        if (!$this->verifyUserPassword($postData['current_pws'], $userID)) {
            $this->error = 'Your password is incorrect.';
            $this->errorTag = 'updateSensitiveInfo';
            return;
        }

        if (!empty($postData['pws'] && !empty($postData['rpws']))) {
            if ($postData['pws'] !== $postData['rpws']) {
                $this->error = 'Your passwords do not match.';
                $this->errorTag = 'updateSensitiveInfo';
                return;
            }

            $user->setPassword($this->hashPassword($postData['pws']));
        }

        $this->updateUserSensitiveInfo($user);

        header('Location: /account/updateInfo');
        die;
    }

    /**
     * Performs the UPDATE action against the database.
     *
     * @param User $user  Contains the new user information
     */
    private function updateUserGeneralInfo(User $user)
    {
        $updateUserQuery = $this->pdo->prepare(
            'UPDATE Users
             SET forename = :fname
               , surname = :sname
             WHERE user_id = :userID'
        );

        $updateUserQuery->bindValue('fname', $user->getForename());
        $updateUserQuery->bindValue('sname', $user->getSurname());
        $updateUserQuery->bindValue('userID', $user->getUserID());

        $updateUserQuery->execute();
    }

    /**
     * Performs the UPDATE action against the database.
     *
     * @param User $user  Contains the new user information
     */
    private function updateUserSensitiveInfo(User $user)
    {
        $sql = 'UPDATE Users SET email = :email';

        $userPassword = $user->getPassword();

        if ($userPassword !== '') {
            $sql .= ', password = :password';
        }

        $sql .= ' WHERE user_id = :userID';

        $updateUserQuery = $this->pdo->prepare($sql);

        $updateUserQuery->bindValue('email', $user->getEmail());
        $updateUserQuery->bindValue('userID', $user->getUserID());

        if ($userPassword !== '') {
            $updateUserQuery->bindValue('password', $user->getPassword());
        }

        $updateUserQuery->execute();
    }

    /**
     * Gets the error instance variable.
     *
     * @return string  The error message or an empty string if no error occurred
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Gets the tag of the error.
     *
     * @return string  The tag of the error message or an empty string if no tag is set
     */
    public function getErrorTag()
    {
        return $this->errorTag;
    }

    /**
     * Insert a user from the User domain object.
     *
     * @param  User  Contains the user information to be inserted
     * @return int   The ID of the user that has just been inserted
     */
    private function insertUser(User $user)
    {
        $userQuery = $this->pdo->prepare(
            'INSERT INTO Users
             VALUES (NULL, :email, :pws, :forename, :surname, :privilege)'
        );

        $userQuery->bindValue('email', $user->getEmail());
        $userQuery->bindValue('pws', $user->getPassword());
        $userQuery->bindValue('forename', $user->getForename());
        $userQuery->bindValue('surname', $user->getSurname());
        $userQuery->bindValue('privilege', $user->getPrivilegeLevel(), \PDO::PARAM_INT);
        $userQuery->execute();

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Gets the user information and puts it into a User object.
     *
     * @param  int   $userID     The ID of the user to get
     * @param  array $colsToGet  The projection of user data to get
     * @return User              The user information
     */
    public function getUser($userID, array $colsToGet = [])
    {
        $userCols = ['email', 'forename', 'surname', 'password', 'privilege_level'];

        if (empty($colsToGet)) {
            $colsToGet = $userCols;
        } else {
            if (!empty(array_diff($colsToGet, $userCols))) {
                die('Invalid columns specified in a view'); // could be an assertion?
            }
        }

        $sql = 'SELECT ';
        $sql .= implode(',', $colsToGet);
        $sql .= ' FROM Users WHERE user_id = ?';

        $userQuery = $this->pdo->prepare($sql);
        $userQuery->execute([$userID]);

        if (empty($userInfo = $userQuery->fetch(\PDO::FETCH_ASSOC))) {
            $this->error = 'A user does not exist with the specified ID.';
            return;
        }

        $user = new User($userID);

        if (isset($userInfo['forename'])) {
            $user->setForename($userInfo['forename']);
        }

        if (isset($userInfo['surname'])) {
            $user->setSurname($userInfo['surname']);
        }

        if (isset($userInfo['email'])) {
            $user->setEmail($userInfo['email']);
        }

        if (isset($userInfo['password'])) {
            $user->setPassword($userInfo['password']);
        }

        if (isset($userInfo['privilege_level'])) {
            $user->setPrivilegeLevel($userInfo['privilege_level']);
        }

        return $user;
    }
}
