<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Classes\Reservation;



if (isset($_POST['confirmer'])) {
    $r = new Reservation($_POST['id_user'], $_POST['id_vehicule'], '', '');
    $r->confirmerReservation();
}

if (isset($_POST['annuler'])) {
    $r = new Reservation($_POST['id_user'], $_POST['id_vehicule'], '', '');
    $r->annulerReservation();
}


$reservations = Reservation::listerToutesLesReservations();
?>
<?php
require_once '../Components/TOP_SIDE_BAR.php';
?>

<main class="p-6 bg-gray-100 flex-1">

  <!-- Title -->
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Gestion des réservations</h2>
    <p class="text-gray-500 text-sm">Consulter et gérer toutes les réservations</p>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm text-left">
      <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
        <tr>
          <th class="px-6 py-4">Client</th>
          <th class="px-6 py-4">Véhicule</th>
          <th class="px-6 py-4">Dates</th>
          <th class="px-6 py-4">Statut</th>
          <th class="px-6 py-4 text-center">Actions</th>
        </tr>
      </thead>

      <tbody class="divide-y">
        <?php foreach ($reservations as $r): ?>
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4">
            <p class="font-medium"><?= htmlspecialchars($r['client_nom']) ?></p>
            <p class="text-xs text-gray-500"><?= htmlspecialchars($r['email']) ?></p>
          </td>

          <td class="px-6 py-4 font-medium">
            <?= htmlspecialchars($r['modele']) ?>
          </td>

          <td class="px-6 py-4">
            <p><?= $r['date_debut'] ?></p>
            <p class="text-gray-500 text-xs"><?= $r['date_fin'] ?></p>
          </td>

          <td class="px-6 py-4">
            <?php
              $color = match($r['statut_reservation']) {
                'confirmee' => 'green',
                'annulee' => 'red',
                default => 'yellow'
              };
            ?>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                         bg-<?= $color ?>-100 text-<?= $color ?>-700">
              <?= ucfirst($r['statut_reservation']) ?>
            </span>
          </td>

          <td class="px-6 py-4">
            <?php if ($r['statut_reservation'] === 'en_attente'): ?>
              <div class="flex gap-2 justify-center">

                <!-- Confirmer -->
                <form method="POST">
                  <input type="hidden" name="id_user" value="<?= $r['id_utilisateur'] ?>">
                  <input type="hidden" name="id_vehicule" value="<?= $r['id_vehicule'] ?>">
                  <button name="confirmer"
                          class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                    Confirmer
                  </button>
                </form>

                <!-- Annuler -->
                <form method="POST">
                  <input type="hidden" name="id_user" value="<?= $r['id_utilisateur'] ?>">
                  <input type="hidden" name="id_vehicule" value="<?= $r['id_vehicule'] ?>">
                  <button name="annuler"
                          class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Annuler
                  </button>
                </form>

              </div>
            <?php else: ?>
              <span class="text-gray-400 text-xs">Aucune action</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</main>
