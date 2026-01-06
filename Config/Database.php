<?php
namespace App\Config;
use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $con;
    private string $dsn = "mysql:host=localhost;dbname=mabagnole";
    private string $user = 'root';
    private string $pws = ''; 

    private function __construct()
    {
        try {
            $this->con = new PDO(
                $this->dsn,
                $this->user,
                $this->pws,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die('Erreur de connexion: '.$e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;   
    }

    public function getConnexion():PDO
    {
        return $this->con;
    }
}

?>