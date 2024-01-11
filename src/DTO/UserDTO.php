<?php

namespace Root\MvcApi\DTO;

use Root\MvcApi\Model\User;

class UserDTO
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser(array $data): User
    {
        $this->user->setEmail($data['email']);
        $this->user->setName($data['name']);
        $this->user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $this->user->setAvatar($data['avatar']);

        return $this->user;
    }
}
