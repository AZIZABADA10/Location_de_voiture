<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Classes\Vehicule;

$id = $_GET['id'] ?? 0;

$vehicules = ($id == 0)
    ? Vehicule::listerVehicule(8, 0)
    : Vehicule::filtrerVehiculeParCategorie((int)$id);

require __DIR__ . '/vehiculesPartial.php';
