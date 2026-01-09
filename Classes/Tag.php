<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Tag
{
    private ?int $id_tag;
    private string $tag;

    public function __construct(?int $id_tag, string $tag)
    {
        $this->id_tag = $id_tag;
        $this->tag = $tag;
    }

    public function ajouterTag(): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "INSERT INTO Tag (tag) VALUES (?)";
        $stmt = $con->prepare($sql);

        return $stmt->execute([$this->tag]);
    }

    public function modifierTag(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "UPDATE Tag SET tag = ? WHERE id_tag = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([
            $this->tag,
            $id
        ]);
    }

    public function supprimerTag(int $id): bool
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "DELETE FROM Tag WHERE id_tag = ?";
        $stmt = $con->prepare($sql);

        return $stmt->execute([$id]);
    }

    public static function getAllTag(): array
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM Tag";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getTagById(int $id): ?object
    {
        $con = Database::getInstance()->getConnexion();
        $sql = "SELECT * FROM Tag WHERE id_tag = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
