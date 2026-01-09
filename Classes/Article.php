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

    public static function getAllArticle(): array
    {
        $connexion = Database::getInstance()->getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM Article");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getArticleById(int $id): ?object
    {
        $connexion = Database::getInstance()->getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM Article WHERE id_article = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function getAllArticleByTheme(int $id_theme, string $search = '', ?int $tag_id = null): array
    {
        $conn = Database::getInstance()->getConnexion();
        
        $sql = "SELECT a.* 
                FROM Article a
                LEFT JOIN tagArticle ta ON a.id_article = ta.id_article
                LEFT JOIN Tag t ON ta.id_tag = t.id_tag
                WHERE a.id_theme = ? AND a.statut_article = 1";
        
        $params = [$id_theme];

        if ($search !== '') {
            $sql .= " AND a.titre LIKE ?";
            $params[] = "%$search%";
        }

        if ($tag_id !== null) {
            $sql .= " AND ta.id_tag = ?";
            $params[] = $tag_id;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}
