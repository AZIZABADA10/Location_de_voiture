<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
use App\Classes\Utilisateur;
$logout = Utilisateur::logout();
?>