<?php

class ArticleModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllArticles()
    {
        $query = $this->db->query("SELECT * FROM articles");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findArticleById($id)
    {
        $query = $this->db->prepare("SELECT * FROM articles WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function createArticle($data)
    {
        $insertQuery = $this->db->prepare("INSERT INTO articles (name, article_body, author, author_avatar) VALUES (?, ?, ?, ?)");
        return $insertQuery->execute([$data['name'], $data['article_body'], $data['author'], $data['author_avatar']]);
    }

    public function updateArticle($id, $data)
    {
        $updateQuery = $this->db->prepare("UPDATE articles SET name = ?, article_body = ?, author = ?, author_avatar = ? WHERE id = ?");
        return $updateQuery->execute([$data['name'], $data['article_body'], $data['author'], $data['author_avatar'], $id]);
    }

    public function deleteArticle($id)
    {
        $deleteQuery = $this->db->prepare("DELETE FROM articles WHERE id = ?");
        return $deleteQuery->execute([$id]);
    }
}
