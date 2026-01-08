<?php
namespace App\Classes;

use App\Config\Database;
use PDO;

class Commentaire
{
    private ?int $id_commentaire;
    private string $commentaire;
    private string $date_commentaire;
    private int $id_article;

    public function __construct(?int $id_commentaire,string $commentaire,int $id_article,string $date_commentaire = "")
    {
        $this->id_commentaire = $id_commentaire;
        $this->commentaire = $commentaire;
        $this->id_article = $id_article;
        $this->date_commentaire = $date_commentaire;
    }


    public function ajouter_commentaire(): Commentaire
    {
        $con = Database::getInstance()->getConnexion();

        $sql = "INSERT INTO commentaire (commentaire, id_article)
                VALUES (?, ?)";

        $stmt = $con->prepare($sql);
        $stmt->execute([
            $this->commentaire,
            $this->id_article
        ]);

        $this->id_commentaire = $con->lastInsertId();

        return $this;
    }

    public function modifier_commentaire(): Commentaire
    {
        $con = Database::getInstance()->getConnexion();

        $sql = "UPDATE commentaire
                SET commentaire = ?
                WHERE id_commentaire = ?";

        $stmt = $con->prepare($sql);
        $stmt->execute([
            $this->commentaire,
            $this->id_commentaire
        ]);

        return $this;
    }


    public function supprimer_commentaire(): bool
    {
        $con = Database::getInstance()->getConnexion();

        $sql = "UPDATE commentaire
                SET est_supprime = 1
                WHERE id_commentaire = ?";

        $stmt = $con->prepare($sql);
        return $stmt->execute([$this->id_commentaire]);
    }


    public static function getCommentairesParArticle(int $id_article): array
    {
        $con = Database::getInstance()->getConnexion();

        $sql = "SELECT *
                FROM commentaire
                WHERE id_article = ?
                AND est_supprime = 0
                ORDER BY date_commentaire DESC";

        $stmt = $con->prepare($sql);
        $stmt->execute([$id_article]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
