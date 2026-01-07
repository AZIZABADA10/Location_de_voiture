<?php

namespace App\Classes;
use App\Config\Database;
use App\Classes\Theme;

use PDO;

class Article 
{
    private ?int $id_article;
    private string $titre;
    private string $contenu;
    private bool $statut_article; 
    private int $id_theme;

    public function __construct(int $id_article, string $titre, string $contenu,bool $statut_article,int $id_theme)
    {
        $this->id_article = $id_article;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->statut_article = $statut_article;
        $this->id_theme = $id_theme;
    }

    public function ajouterArticle():bool
    {
        $connexion = Database::getInstance()->getConnexion();
        $sql= "INSERT INTO Article (titre,contenu,statut_article,id_theme) values (?,?,?,?,?)";
        $stmt = $connexion -> prepare($sql);
        return $stmt -> execute([$this->titre,$this->contenu,$this->statut_article,$this->id_theme]);
    }

    public function modifierArticle():bool
    {
        $connexion = Database::getInstance()->getConnexion();
        $sql = "INSERT INTO Article";
    }
}