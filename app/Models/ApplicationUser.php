<?php


namespace App\Models;

use Controllers\DatabaseController;
use PDO;

class ApplicationUser{

    //ORM in Laravel may require ID
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $isDeactivated;
    private $secret;

    private DatabaseController $db;

    function __construct($db){
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIsDeactivated()
    {
        return $this->isDeactivated;
    }

    /**
     * @param mixed $isDeactivated
     */
    public function setIsDeactivated($isDeactivated)
    {
        $this->isDeactivated = $isDeactivated;
    }

    public function setSecret($secret) {
        $this->secret = $secret;
    }
    
    public function getSecret() {
        return $this->secret;
    }

    public function getdb() {
        return $this->db;
    }

    public function create(): bool
{
    $stmt = $this->db->getConnection()->prepare("
        INSERT INTO users (userName, firstName, lastName, email, password, isDeactivated, secret)
        VALUES (:userName, :firstName, :lastName, :email, :password, :isDeactivated, :secret)
    ");

    if ($stmt->execute([
        ':userName' => $this->userName,
        ':firstName' => $this->firstName,
        ':lastName' => $this->lastName,
        ':email' => $this->email,
        ':password' => $this->password,
        ':isDeactivated' => (int)$this->isDeactivated,
        ':secret' => $this->secret
    ])) {
        $this->userID = (int)$this->db->getConnection()->lastInsertId();
        return true;
    }
    return false;
}

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

public function delete(int $id): bool
{
    $stmt = $this->db->getConnection()->prepare("DELETE FROM users WHERE userID = :id");
    return $stmt->execute([':id' => $id]);
}

public function updateStatusByUsername(): bool
{
    $stmt = $this->db->getConnection()->prepare("
        UPDATE users SET isDeactivated = :isDeactivated WHERE userName = :username
    ");
    return $stmt->execute([
        ':isDeactivated' => (int)$this->isDeactivated,
        ':username' => $this->userName
    ]);
}

public static function selectById(PDO $pdo, int $id): ?self
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = :id");
    $stmt->execute([':id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $user = new self(
            $data['userID'],
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['password'],
            (bool)$data['isDeactivated'],
            $data['secret']
        );
        $user->setUserName($data['userName']);
        return $user;
    }
    return null;
}

public static function selectAll(PDO $pdo): array
{
    $stmt = $pdo->query("SELECT * FROM users");
    $users = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = new self(
            $row['userID'],
            $row['firstName'],
            $row['lastName'],
            $row['email'],
            $row['password'],
            (bool)$row['isDeactivated'],
            $row['secret']
        );
        $user->setUserName($row['userName']);
        $user->setUserID($row['userID']);
        $users[] = $user;
    }
    return $users;
}

public static function selectByUsername(PDO $pdo, string $username): ?self
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :username");
    $stmt->execute([':username' => $username]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $user = new self($pdo);
        $user->setUserID($data['userID']);
        $user->setUserName($data['userName']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setIsDeactivated((bool)$data['isDeactivated']);
        $user->setSecret($data['secret']);
        return $user;
    }

    return null;
}


}
?>
