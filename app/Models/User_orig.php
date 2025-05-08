<?php


namespace App\Models;

use PDO;

class User_orig{

    //ORM in Laravel may require ID
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $isDeactivated;
    private $isAdmin;

    function __construct($userID, $firstName, $lastName, $email, $password, $isDeactivated, $isAdmin){
        //Let DB auto assign ID (insert method in controller returns ID from DB
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->isDeactivated = (bool)$isDeactivated;
        $this->$isAdmin = (bool)$isAdmin;
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

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function create(PDO $pdo): bool
{
    $stmt = $pdo->prepare("
        INSERT INTO users (userName, firstName, lastName, email, password, isDeactivated, isAdmin)
        VALUES (:userName, :firstName, :lastName, :email, :password, :isDeactivated, :isAdmin)
    ");

    if ($stmt->execute([
        ':userName' => $this->userName,
        ':firstName' => $this->firstName,
        ':lastName' => $this->lastName,
        ':email' => $this->email,
        ':password' => $this->password,
        ':isDeactivated' => (int)$this->isDeactivated,
        ':isAdmin' => (int)$this->isAdmin
    ])) {
        $this->userID = (int)$pdo->lastInsertId();
        return true;
    }
    return false;
}

public function update(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("
        UPDATE users
        SET userName = :userName, firstName = :firstName, lastName = :lastName,
            email = :email, password = :password, isDeactivated = :isDeactivated, isAdmin = :isAdmin
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
        ':isAdmin' => $this->isAdmin
    ]);
}

public function delete(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("DELETE FROM users WHERE userID = :id");
    return $stmt->execute([':id' => $id]);
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
            (bool)$data['isAdmin']
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
            (bool)$row['isAdmin']
        );
        $user->setUserName($row['userName']);
        $user->setUserID($row['userID']);
        $users[] = $user;
    }
    return $users;
}

}
?>
