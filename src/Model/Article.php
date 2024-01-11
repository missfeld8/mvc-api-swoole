<?php

namespace Root\MvcApi\Model;

use DateTime;

class Article
{
    private int $id;
    private string $title;
    private string $articleBody;
    private bool $active;
    private int $userId;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getArticleBody()
    {
        return $this->articleBody;
    }

    public function setArticleBody(string $articleBody)
    {
        $this->articleBody = $articleBody;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
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
