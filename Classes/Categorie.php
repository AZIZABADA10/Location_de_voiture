<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Categorie
{
    private ?int $id_categorie;
    private string $titre;
    private string $description;

    public function __construct(string $titre, string $description, ?int $id = null)
    {
        $this->id_categorie = $id;
        $this->titre = $titre;
        $this->description = $description;
    }

    public function ajouterCategorie(): bool
    {
        $sql = "INSERT INTO categorie (titre, description)
                VALUES (:titre, :description)";

        return Database::getInstance()->getConnexion()->prepare($sql)
            ->execute([
                ':titre' => $this->titre,
                ':description' => $this->description
            ]);
    }

    public function modifierCategorie(): bool
    {
        $sql = "UPDATE categorie SET titre=:titre, description=:description
                WHERE id_categorie=:id";

        return Database::getInstance()->getConnexion()->prepare($sql)
            ->execute([
                ':titre' => $this->titre,
                ':description' => $this->description,
                ':id' => $this->id_categorie
            ]);
    }

    public function supprimerCategorie(): bool
    {
        return Database::getInstance()->getConnexion()
            ->prepare("DELETE FROM categorie WHERE id_categorie=:id")
            ->execute([':id' => $this->id_categorie]);
    }

    public static function listerCategorie(): array
    {
        return Database::getInstance()->getConnexion()
            ->query("SELECT * FROM categorie ORDER BY titre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
