<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

abstract class Utilisateur
{
    protected ?int $id_utilisateur;
    protected string $nom;
    protected string $email;
    protected string $mot_de_passe;
    protected string $role;

    public function __construct(string $nom,string $email,string $mot_de_passe,string $role = 'client',?int $id_utilisateur = null)
     {
        $this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->email = $email;
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $this->role = $role;
    }

    public static function login(string $email, string $mot_de_passe): array
    {
        $db = Database::getInstance()->getConnexion();

        $stmt = $db->prepare(
            "SELECT * FROM utilisateur WHERE email = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'success' => false,
                'message' => "Cet email n'existe pas"
            ];
        }

        if (!password_verify($mot_de_passe, $user['mot_de_passe'])) {
            return [
                'success' => false,
                'message' => "Mot de passe incorrect"
            ];
        }

        $_SESSION['user'] = [
            'id'   => $user['id_utilisateur'],
            'nom'  => $user['nom'],
            'role' => $user['role'] ?? 'client'  
        ];


        return [
            'success' => true,
            'message' => "Connexion réussie"
        ];
    }

    public static function logout(): void
    {
        session_destroy();
        header('Location: index.php');
        exit();
    }


    public static function listerUtilisateur(): array
    {
        $sql = "SELECT * FROM utilisateur ";
        $stmt = Database::getInstance()->getConnexion()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
