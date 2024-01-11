<?php

namespace Root\MvcApi\Model;

use DateTime;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private bool $active;
    private string $avatar;
    private DateTime $createdAt;
    private DateTime $updateAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar)
    {
        $this->avatar = $avatar;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function setUpdateAt(DateTime $updateAt)
    {
        $this->updateAt = $updateAt;
    }
}
