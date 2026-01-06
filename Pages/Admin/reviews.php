<?php
require_once '../Components/TOP_SIDE_BAR.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Classes\Avis;
use App\Classes\Vehicule;
use App\Classes\Utilisateur;

if (isset($_GET['supprimer'])) {
    $idVehicule = (int)$_GET['id_vehicule'];
    $idUser = (int)$_GET['id_user'];
    Avis::supprimerAvis($idVehicule, $idUser);
    header("Location: gestion_avis.php?success=1");
    exit;
}


$vehicules = Vehicule::listerVehicule(100,0);
$avisListe = [];
foreach ($vehicules as $v) {
    $avis = Avis::avisParVehicule($v['id_vehicule']);
    foreach ($avis as $a) {
        $avisListe[] = [
            'id_vehicule' => $v['id_vehicule'],
            'modele' => $v['modele'],
            'marque' => $v['marque'],
            'id_user' => $a['id_utilisateur'],
            'nom_user' => $a['nom'],
            'commentaire' => $a['commentaire'],
            'date_avis' => $a['date_avis']
        ];
    }
}
?>

<main class="p-6">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Gestion des Avis</h2>
  </div>

  <!-- Table des avis -->
  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Véhicule</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Date</th>
          <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php foreach ($avisListe as $a): ?>
        <tr>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['modele'] . ' (' . $a['marque'] . ')') ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['nom_user']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['commentaire']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($a['date_avis']) ?></td>
          <td class="px-6 py-4 text-sm text-right">
            <a href="?supprimer=1&id_vehicule=<?= $a['id_vehicule'] ?>&id_user=<?= $a['id_user'] ?>"
               onclick="return confirm('Voulez-vous vraiment supprimer cet avis ?')"
               class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
              Supprimer
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($avisListe)): ?>
        <tr>
          <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun avis trouvé</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</main>
