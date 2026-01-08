<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Theme
{
    private ?int $id_theme;
    private string $titre;
    private string $description;

    public function __construct(?int $id_theme, string $titre, string $description)
    {
        $this->id_theme = $id_theme;
        $this->titre = $titre;
        $this->description = $description;
    }

    public function ajouterTheme(): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "INSERT INTO Theme (titre, description) VALUES (?, ?)";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->titre,
            $this->description
        ]);
    }

    public function modifierTheme(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "UPDATE Theme SET titre = ?, description = ? WHERE id_theme = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->titre,
            $this->description,
            $id
        ]);
    }

    public function supprimerTheme(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "DELETE FROM Theme WHERE id_theme = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function getAllTheme(): array
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM Theme";

        return $con->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function getThemeById(int $id): ?object
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM Theme WHERE id_theme = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
