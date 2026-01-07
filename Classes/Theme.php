<?php

namespace App\Classes;
use App\Config\Database;
use PDO;

class Theme 
{

   private int $id_theme;
   private string $titre;
   private $description;

   public function __construct(int $id_theme,string $titre,$description)
   {
        $this->id_theme = $id_theme;
        $this->titre = $titre;
        $this->description = $description;
   }
   
   public function ajouterTheme(): bool 
   {
    $con = DataBase::getInstance()->getConnexion();
    $sql = "INSERT INTO Theme (titre,description) 
    values (?,?)";
    $stmt = $con -> prapare($sql);
    return $stmt -> execute([$this->titre,$this->description]);
   }

   public function modifierThem(int $id): bool
   {
    $con = Database::getInstance()->getConnexion();
    $sql = "UPDATE Theme SET 
    titre = ?, description=? WHERE id_theme = ?";
    $stmt = $con -> prepare($sql);
    return $stmt -> execute([$this->titre,$this->description,$id]);
   }

   public function supprimerThem(ind $id): bool 
   {
      $con = Database::getInstance()->getConnexion();
      $sql = "DELETE from Theme where id_theme = ?";
      $stmt = $con -> prepare($sql);
      return $stmt -> execute([$id]);
   }


   public function getAllTheme(): array
   {
      $con = Database::getInstance()->getConnexion();
      $sql = "SELECT * FROM Theme";
      return $con->query($sql)->fetchAll(PDO::FETCH_OBJ);
   }

   public function getThemeById(int $id) 
   {
      $con = Database::getInstance()->getConnexion();
      $sql = "SELECT * FROM Theme where id = ?";
      $stmt = $con -> prepare($sql);
      return $stmt -> execute([$id]);
   }

}


?>