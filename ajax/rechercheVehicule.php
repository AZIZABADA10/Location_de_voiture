<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Classes\Vehicule;

$q = $_GET['q'] ?? '';
$vehicules = Vehicule::rechercher($q);

require __DIR__ . '/vehiculesPartial.php';
