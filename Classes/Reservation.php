<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Reservation
{
    private int $id_utilisateur;
    private int $id_vehicule;
    private string $date_debut;
    private string $date_fin;
    private string $statut_reservation;

    public function __construct(int $id_utilisateur,int $id_vehicule,string $date_debut,string $date_fin,string $statut_reservation = 'en_attente') 
    {
        $this->id_utilisateur = $id_utilisateur;
        $this->id_vehicule = $id_vehicule;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut_reservation = $statut_reservation;
    }


    public function ajouterReservation(): bool
    {
        $sql = "CALL AjouterReservation(?,?,?,?)";
        return Database::getInstance()->getConnexion()->prepare($sql)->execute([$this->id_utilisateur,$this->id_vehicule,$this->date_debut,$this->date_fin]);
    }


    public function modifierReservation(string $nouvelle_date_debut,string $nouvelle_date_fin): bool 
    {
        $sql = "UPDATE reservation SET
                    date_debut = :date_debut,
                    date_fin = :date_fin
                WHERE id_utilisateur = :id_user
                  AND id_vehicule = :id_vehicule";

        return Database::getInstance()->getConnexion()->prepare($sql)->execute([':date_debut' => $nouvelle_date_debut,':date_fin' => $nouvelle_date_fin,':id_user' => $this->id_utilisateur,':id_vehicule' => $this->id_vehicule]);
    }

    public function annulerReservation(): bool
    {
        $sql = "UPDATE reservation SET
                    statut_reservation = 'annulee'
                WHERE id_utilisateur = :id_user
                  AND id_vehicule = :id_vehicule";
        return Database::getInstance()->getConnexion()->prepare($sql)->execute([':id_user' => $this->id_utilisateur,':id_vehicule' => $this->id_vehicule]);
    }


    public function confirmerReservation(): bool
    {
        $sql = "UPDATE reservation SET
                    statut_reservation = 'confirmee'
                WHERE id_utilisateur = :id_user
                  AND id_vehicule = :id_vehicule";
        return Database::getInstance()->getConnexion()->prepare($sql)->execute([':id_user' => $this->id_utilisateur,':id_vehicule' => $this->id_vehicule]);
    }

    public static function listerReservationsParUtilisateur(int $id_utilisateur): array
    {
        $sql = "SELECT r.*, v.modele, v.prix_par_jour
                FROM reservation r
                JOIN vehicule v ON r.id_vehicule = v.id_vehicule
                WHERE r.id_utilisateur = :id_user
                ORDER BY r.date_debut DESC";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->execute([':id_user' => $id_utilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listerToutesLesReservations(): array
    {
        $sql = "SELECT r.*, 
                    u.nom AS client_nom, u.email,
                    v.modele
                FROM reservation r
                JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                JOIN vehicule v ON r.id_vehicule = v.id_vehicule
                ORDER BY r.date_debut DESC";

        return Database::getInstance()->getConnexion()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function compterReservations(): int
    {
        $sql = "SELECT COUNT(*) as total FROM reservation";
        $stmt = Database::getInstance()->getConnexion()->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    public static function vehiculeLePlusReserve(): ?array
    {
        $sql = "SELECT v.*, COUNT(r.id_vehicule) AS nb_reservations
                FROM reservation r
                JOIN vehicule v ON r.id_vehicule = v.id_vehicule
                GROUP BY r.id_vehicule
                ORDER BY nb_reservations DESC
                LIMIT 1";

        $stmt = Database::getInstance()->getConnexion()->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }


}
