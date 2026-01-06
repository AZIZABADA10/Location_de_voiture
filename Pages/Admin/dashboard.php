<?php
require_once '../Components/TOP_SIDE_BAR.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Classes\Vehicule;
use App\Classes\Categorie;
use App\Classes\Utilisateur;
use App\Classes\Avis;
use App\Classes\Reservation; 


$totalVehicules = count(Vehicule::listerVehicule(1000,0));
$totalCategories = count(Categorie::listerCategorie());
$totalUtilisateurs = count(Utilisateur::listerUtilisateur(1000,0));
$totalAvis = count(Avis::avisParVehicule(0)); 
$totalReservations = Reservation::compterReservations(); 


$topVehicule = Reservation::vehiculeLePlusReserve(); 


$dernierAvis = [];
$vehicules = Vehicule::listerVehicule(1000,0);
foreach ($vehicules as $v) {
    $avis = Avis::avisParVehicule($v['id_vehicule']);
    foreach ($avis as $a) {
        $dernierAvis[] = [
            'vehicule' => $v['modele'].' ('.$v['marque'].')',
            'utilisateur' => $a['nom'],
            'commentaire' => $a['commentaire'],
            'date' => $a['date_avis']
        ];
    }
}

usort($dernierAvis, fn($a,$b)=>strtotime($b['date']) - strtotime($a['date']));
$dernierAvis = array_slice($dernierAvis,0,5); 


$dernierVehicules = array_slice($vehicules,-5); 

?>

<main class="p-6 space-y-6">

  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>

  <!-- Statistiques générales -->
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-blue-500 text-white p-4 rounded shadow">
      <h3 class="text-lg font-semibold">Véhicules</h3>
      <p class="text-2xl"><?= $totalVehicules ?></p>
    </div>
    <div class="bg-green-500 text-white p-4 rounded shadow">
      <h3 class="text-lg font-semibold">Catégories</h3>
      <p class="text-2xl"><?= $totalCategories ?></p>
    </div>
    <div class="bg-yellow-400 text-white p-4 rounded shadow">
      <h3 class="text-lg font-semibold">Utilisateurs</h3>
      <p class="text-2xl"><?= $totalUtilisateurs ?></p>
    </div>
    <div class="bg-purple-500 text-white p-4 rounded shadow">
      <h3 class="text-lg font-semibold">Réservations</h3>
      <p class="text-2xl"><?= $totalReservations ?></p>
    </div>
    <div class="bg-red-500 text-white p-4 rounded shadow">
      <h3 class="text-lg font-semibold">Avis</h3>
      <p class="text-2xl"><?= $totalAvis ?></p>
    </div>
  </div>

<div class="bg-white rounded shadow p-4 mb-6">
    <h3 class="text-xl font-semibold mb-2">Véhicule le plus réservé</h3>
    <?php if($topVehicule): ?>
        <p class="text-gray-700">
            <?= htmlspecialchars($topVehicule['modele'] . ' (' . $topVehicule['marque'] . ')') ?> - 
            <span class="font-bold"><?= $topVehicule['nb_reservations'] ?? 0 ?> réservations</span>
        </p>
    <?php else: ?>
        <p class="text-gray-500">Aucune réservation encore.</p>
    <?php endif; ?>
</div>


  <!-- Derniers avis -->
  <div class="bg-white rounded shadow p-4 mb-6">
    <h3 class="text-xl font-semibold mb-2">Derniers avis</h3>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Véhicule</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Date</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php foreach($dernierAvis as $a): ?>
        <tr>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['vehicule']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['utilisateur']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['commentaire']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['date']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Derniers véhicules ajoutés -->
  <div class="bg-white rounded shadow p-4 mb-6">
    <h3 class="text-xl font-semibold mb-2">Derniers véhicules ajoutés</h3>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Modèle</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Marque</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Prix/Jour</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php foreach($dernierVehicules as $v): ?>
        <tr>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($v['modele']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($v['marque']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= number_format($v['prix_par_jour'],2,',',' ') ?> DH</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</main>
