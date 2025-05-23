<?php

namespace App\Models\users;

use App\Http\Controllers\core\DatabaseController;
use PDO;

class User
{

    // Private properties for the User model
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $isDeactivated;
    private $secret;

    // Database connection instance
    private DatabaseController $db;

    /**
     * Constructor to initialize the User model.
     * 
     * @param DatabaseController $db Database connection instance
     */
    function __construct($db)
    {
        $this->db = $db;
    }

    // Getters and Setters for user properties

    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getIsDeactivated()
    {
        return $this->isDeactivated;
    }

    public function setIsDeactivated($isDeactivated)
    {
        $this->isDeactivated = $isDeactivated;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getdb()
    {
        return $this->db;
    }

    /**
     * Create a new user in the database.
     * 
     * @return bool Returns true if the user was successfully created, false otherwise
     */
    public function create(): bool
    {
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO users (user_name, first_name, last_name, email, password, is_deactivated, twofa_secret)
            VALUES (:userName, :firstName, :lastName, :email, :password, :isDeactivated, :secret)
        ");

        if (
            $stmt->execute([
                ':userName' => $this->userName,
                ':firstName' => $this->firstName,
                ':lastName' => $this->lastName,
                ':email' => $this->email,
                ':password' => $this->password,
                ':isDeactivated' => (int) $this->isDeactivated,
                ':secret' => $this->secret
            ])
        ) {
            $this->userID = (int) $this->db->getConnection()->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Update an existing user in the database.
     * 
     * @param int $id User ID
     * @return bool Returns true if the user was successfully updated, false otherwise
     */
    public function update(int $id): bool
    {
        $stmt = $this->db->getConnection()->prepare("
            UPDATE users
            SET userName = :userName, firstName = :firstName, lastName = :lastName,
                email = :email, password = :password, isDeactivated = :isDeactivated, secret = :secret
            WHERE userID = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':userName' => $this->userName,
            ':firstName' => $this->firstName,
            ':lastName' => $this->lastName,
            ':email' => $this->email,
            ':password' => $this->password,
            ':isDeactivated' => $this->isDeactivated,
            ':secret' => $this->secret
        ]);
    }

    /**
     * Delete a user by their ID.
     * 
     * @param int $id User ID
     * @return bool Returns true if the user was successfully deleted, false otherwise
     */
    public function delete($userId): bool
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM Users WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    /**
     * Update the status of a user by username (deactivate or activate).
     * 
     * @return bool Returns true if the status was successfully updated, false otherwise
     */
    public function updateStatusByUsername(): bool
    {
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Users SET isDeactivated = :isDeactivated WHERE userName = :username
        ");
        return $stmt->execute([
            ':isDeactivated' => (int) $this->isDeactivated,
            ':username' => $this->userName
        ]);
    }

    /**
     * Select a user by their ID.
     * 
     * @param PDO $pdo Database connection
     * @param int $id User ID
     * @return User|null Returns an User object if found, null otherwise
     */
    public static function selectById(DatabaseController $db, int $id): ?self
    {
        $pdo = self::$db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE userID = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new self($db);
            $user->setUserID($data['userID']);
            $user->setUserName($data['userName']);
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setIsDeactivated((bool) $data['isDeactivated']);
            $user->setSecret($data['secret']);
            return $user;
        }

        return null;
    }

    /**
     * Select all users.
     * 
     * @param PDO $pdo Database connection
     * @return array Returns an array of User objects
     */
    public static function selectAll(DatabaseController $db): array
    {
        $pdo = self::$db->getConnection();
        $stmt = $pdo->query("SELECT * FROM users");
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new self($db);
            $user->setUserID($row['userID']);
            $user->setUserName($row['userName']);
            $user->setFirstName($row['firstName']);
            $user->setLastName($row['lastName']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setIsDeactivated((bool) $row['isDeactivated']);
            $user->setSecret($row['secret']);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Select a user by their username.
     * 
     * @param PDO $pdo Database connection
     * @param string $username Username
     * @return User|null Returns an User object if found, null otherwise
     */
    public static function selectByUsername(DatabaseController $db, string $username): ?self
    {
        $pdo = self::$db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :username");
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new self($db);
            $user->setUserID($data['userID']);
            $user->setUserName($data['userName']);
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setIsDeactivated((bool) $data['isDeactivated']);
            $user->setSecret($data['secret']);
            return $user;
        }

        return null;
    }
}