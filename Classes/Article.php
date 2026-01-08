<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Article
{
    private ?int $id_article;
    private string $titre;
    private string $contenu;
    private bool $statut_article;
    private int $id_theme;

    public function __construct(?int $id_article,string $titre,string $contenu,bool $statut_article,int $id_theme)
    {
        $this->id_article = $id_article;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->statut_article = $statut_article;
        $this->id_theme = $id_theme;
    }

    public function ajouterArticle(): bool
    {
        $connexion = Database::getInstance()->getConnexion();
        $sql = "INSERT INTO Article (titre, contenu, statut_article, id_theme)
                VALUES (?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);

        return $stmt->execute([
            $this->titre,
            $this->contenu,
            $this->statut_article,
            $this->id_theme
        ]);
    }

    public function modifierArticle(int $id): bool
    {
        $connexion = Database::getInstance()->getConnexion();
        $sql = "UPDATE Article 
                SET titre = ?, contenu = ?, statut_article = ?, id_theme = ?
                WHERE id_article = ?";
        $stmt = $connexion->prepare($sql);

        return $stmt->execute([
            $this->titre,
            $this->contenu,
            $this->statut_article,
            $this->id_theme,
            $id
        ]);
    }

    public function supprimerArticle(int $id): bool
    {
        $connexion = Database::getInstance()->getConnexion();
        $sql = "DELETE FROM Article WHERE id_article = ?";
        $stmt = $connexion->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function getAllArticle(): array
    {
        $connexion = Database::getInstance()->getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM Article");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getArticleById(int $id): ?object
    {
        $connexion = Database::getInstance()->getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM Article WHERE id_article = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
