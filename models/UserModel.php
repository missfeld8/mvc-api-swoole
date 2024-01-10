<?php

class UserModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function createUser($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $insertQuery = $this->db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        return $insertQuery->execute([$data['email'], $hashedPassword]);
    }

    public function verifyUser($data)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$data['email']]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        return ($user && password_verify($data['password'], $user['password']));
    }
}
