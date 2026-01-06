<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Avis
{

    public static function ajouterAvis(int $idVehicule,int $idUser,string $commentaire): bool
    {
        $sql = "INSERT INTO avis (id_utilisateur, id_vehicule, commentaire, date_avis)
                VALUES (:user, :vehicule, :commentaire, NOW())";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);

        return $stmt->execute([
            ':user' => $idUser,
            ':vehicule' => $idVehicule,
            ':commentaire' => $commentaire
        ]);
    }


    public static function modifierAvis(int $idVehicule,int $idUser,string $commentaire): bool 
    {
        $sql = "UPDATE avis 
                SET commentaire = :commentaire, date_avis = NOW(), deleted_at = NULL
                WHERE id_utilisateur = :user AND id_vehicule = :vehicule";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);

        return $stmt->execute([
            ':user' => $idUser,
            ':vehicule' => $idVehicule,
            ':commentaire' => $commentaire
        ]);
    }


    public static function supprimerAvis(int $idVehicule, int $idUser): bool
    {
        $sql = "UPDATE avis 
                SET deleted_at = NOW()
                WHERE id_utilisateur = :user AND id_vehicule = :vehicule";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);

        return $stmt->execute([
            ':user' => $idUser,
            ':vehicule' => $idVehicule
        ]);
    }

    public static function avisParVehicule(int $idVehicule): array
    {
        $sql = "SELECT a.*, u.nom 
                FROM avis a
                JOIN utilisateur u ON u.id_utilisateur = a.id_utilisateur
                WHERE a.id_vehicule = :vehicule AND a.deleted_at IS NULL
                ORDER BY a.date_avis DESC";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->execute([':vehicule' => $idVehicule]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function avisUtilisateur(int $idVehicule,int $idUser): ?array 
    {
        $sql = "SELECT * FROM avis
                WHERE id_utilisateur = :user 
                AND id_vehicule = :vehicule
                AND deleted_at IS NULL";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->execute([
            ':user' => $idUser,
            ':vehicule' => $idVehicule
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
