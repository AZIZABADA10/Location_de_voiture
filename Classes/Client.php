<?php

namespace App\Classes;

use App\Config\Database;

class Client extends Utilisateur
{
        public static function register(string $nom,string $email,string $mot_de_passe,string $role = 'client'): array 
    {
        $db = Database::getInstance()->getConnexion();
        $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => "Cet email est déjà utilisé"
            ];
        }
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $db->prepare(
            "INSERT INTO utilisateur (nom, email, mot_de_passe, `role`)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nom, $email, $hash, $role]);
        return [
            'success' => true,
            'message' => "Inscription réussie"
        ];
    }
}
