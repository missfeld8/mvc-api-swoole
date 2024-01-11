<?php

namespace Root\MvcApi\Repository;

use PDO;
use Root\MvcApi\Config\Database;
use Root\MvcApi\Model\User;

class UserRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function insertUser(User $user)
    {

        $insertQuery = $this->database->getConnection()->prepare("INSERT INTO users (email, password, name, avatar) VALUES (?, ?, ?, ?)");
        return $insertQuery->execute([$user->getEmail(), $user->getPassword(), $user->getName(), $user->getAvatar()]);
    }

    public function verifyUser(User $user)
    {
        $query = $this->database->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$user->getEmail()]);

        return empty($query->fetch(PDO::FETCH_ASSOC));
    }
}
