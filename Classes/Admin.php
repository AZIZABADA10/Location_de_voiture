<?php

namespace App\Classes;
use App\Config\Database;
use App\Classes\Utilisateur;
use PDO;


class Admin extends Utilisateur 
{
    public function __construct($id_utilisateur,$nom,$email,$role)
    {
        parent:: __construct($id_utilisateur,$nom,$email,$role);
    }

}




