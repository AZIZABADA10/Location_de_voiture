<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class TagArticle
{
    private ?int $id_tagArticle;
    private int $id_tag;
    private int $id_article;

    public function __construct(?int $id_tagArticle, int $id_tag, int $id_article)
    {
        $this->id_tagArticle = $id_tagArticle;
        $this->id_tag = $id_tag;
        $this->id_article = $id_article;
    }

    public function ajouter(): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "INSERT INTO tagArticle (id_tag, id_article) VALUES (?, ?)";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->id_tag,
            $this->id_article
        ]);
    }

    public function modifier(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "UPDATE tagArticle 
                SET id_tag = ?, id_article = ?
                WHERE id_tagArticle = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->id_tag,
            $this->id_article,
            $id
        ]);
    }

    public function supprimer(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "DELETE FROM tagArticle WHERE id_tagArticle = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function getAll(): array
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM tagArticle";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById(int $id): ?object
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM tagArticle WHERE id_tagArticle = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
