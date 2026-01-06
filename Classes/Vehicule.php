<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Vehicule
{
    private ?int $id_vehicule;
    private string $modele;
    private string $marque;
    private float $prix_par_jour;
    private bool $disponible;
    private string $image;
    private int $id_categorie;

    public function __construct(string $modele,string $marque,float $prix_par_jour,int $id_categorie,string $image,bool $disponible = true,?int $id_vehicule = null) 
    {
        $this->id_vehicule = $id_vehicule;
        $this->modele = $modele;
        $this->marque = $marque;
        $this->prix_par_jour = $prix_par_jour;
        $this->id_categorie = $id_categorie;
        $this->image = $image;
        $this->disponible = $disponible;
    }

    public function ajouterVehicule(): bool
    {
        $sql = "INSERT INTO vehicule 
                (modele, marque, prix_par_jour, disponible, image, id_categorie)
                VALUES (:modele, :marque, :prix, :disponible, :image, :categorie)";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);

        return $stmt->execute([
            ':modele' => $this->modele,
            ':marque' => $this->marque,
            ':prix' => $this->prix_par_jour,
            ':disponible' => $this->disponible,
            ':image' => $this->image,
            ':categorie' => $this->id_categorie
        ]);
    }

    public function modifierVehicule(): bool
    {
        $sql = "UPDATE vehicule SET
                    modele = :modele,
                    marque = :marque,
                    prix_par_jour = :prix,
                    disponible = :disponible,
                    id_categorie = :categorie,
                    image = :image
                WHERE id_vehicule = :id";

        $stmt = Database::getInstance()->getConnexion()->prepare($sql);

        return $stmt->execute([
            ':modele' => $this->modele,
            ':marque' => $this->marque,
            ':prix' => $this->prix_par_jour,
            ':disponible' => $this->disponible,
            ':categorie' => $this->id_categorie,
            ':image' => $this->image, 
            ':id' => $this->id_vehicule
        ]);
    }

    public static function trouverVehiculeParId(int $id): ?array
    {
        $sql = "SELECT * FROM vehicule WHERE id_vehicule = ?";
        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }



    public function supprimer(): bool
    {
        $sql = "DELETE FROM vehicule WHERE id_vehicule = :id";
        return Database::getInstance()->getConnexion()->prepare($sql)
            ->execute([':id' => $this->id_vehicule]);
    }

    public static function listerVehicule(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM vehicule LIMIT :limit OFFSET :offset";
        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filtrerVehiculeParCategorie(int $id_categorie): array
    {
        $sql = "SELECT * FROM vehicule WHERE id_categorie = :categorie";
        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->execute([':categorie' => $id_categorie]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function rechercher(string $motCle): array
    {
        $sql = "SELECT * FROM vehicule 
                WHERE modele LIKE :mc OR marque LIKE :mc";
        
        $stmt = Database::getInstance()->getConnexion()->prepare($sql);
        $stmt->execute([':mc' => "%$motCle%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function count(): int
    {
        $sql = "SELECT COUNT(*) FROM vehicule";
        return (int) Database::getInstance()
            ->getConnexion()
            ->query($sql)
            ->fetchColumn();
    }



}
