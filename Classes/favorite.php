<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Favorite
{
    private ?int $id_favorite;
    private int $id_article;
    private int $id_utilisateur;

    public function __construct(?int $id_favorite, int $id_article, int $id_utilisateur)
    {
        $this->id_favorite = $id_favorite;
        $this->id_article = $id_article;
        $this->id_utilisateur = $id_utilisateur;
    }

    public function ajouterFavorite(): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "INSERT INTO favorite (id_article, id_utilisateur)
                VALUES (?, ?)";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->id_article,
            $this->id_utilisateur
        ]);
    }

    public function modifierFavorite(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "UPDATE favorite
                SET id_article = ?, id_utilisateur = ?
                WHERE id_favorite = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->id_article,
            $this->id_utilisateur,
            $id
        ]);
    }

    public function supprimerFavorite(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "DELETE FROM favorite WHERE id_favorite = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function getAllFavorite(): array
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM favorite";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFavoriteById(int $id): ?object
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM favorite WHERE id_favorite = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
