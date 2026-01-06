<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Reservation;

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user']['id'];
$reservations = Reservation::listerReservationsParUtilisateur($id_user);

// Annulation
if (isset($_POST['annuler'])) {
    $reservation = new Reservation(
        $id_user,
        $_POST['id_vehicule'],
        $_POST['date_debut'],
        $_POST['date_fin']
    );
    $reservation->annulerReservation();
    header("Location: espace_client.php");
    exit;
}

// Modification
if (isset($_POST['modifier'])) {
    $reservation = new Reservation(
        $id_user,
        $_POST['id_vehicule'],
        $_POST['date_debut'],
        $_POST['date_fin']
    );
    $reservation->modifierReservation($_POST['new_date_debut'], $_POST['new_date_fin']);
    header("Location: espace_client.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon espace client - MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<header class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between">
        <h1 class="text-xl font-bold text-blue-600">Mon espace client</h1>
        <div class="hidden md:flex space-x-6">
                <a href="index.php" class="text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="nos_voitures.php" class="text-gray-700 hover:text-blue-600">Nos voitures</a>
            </div>
        <a href="logout.php"
                   class="px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50">
                    Déconnexion
        </a>
    </div>
</header>

<section class="h-screen container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Mes réservations</h2>

    <?php if (empty($reservations)): ?>
        <p class="text-gray-500">Aucune réservation trouvée.</p>
    <?php endif; ?>

    <?php foreach ($reservations as $r): ?>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold"><?= htmlspecialchars($r['modele']) ?></h3>
                    <p class="text-gray-500">
                        Du <?= $r['date_debut'] ?> au <?= $r['date_fin'] ?>
                    </p>
                    <p class="mt-1">
                        Statut :
                        <span class="font-semibold
                            <?= $r['statut_reservation'] === 'annulee' ? 'text-red-600' : 'text-green-600' ?>">
                            <?= ucfirst($r['statut_reservation']) ?>
                        </span>
                    </p>
                </div>
            </div>

            <?php if ($r['statut_reservation'] === 'en_attente'): ?>
            <div class="mt-4 flex gap-4">

                <!-- Annuler -->
                <form method="POST">
                    <input type="hidden" name="id_vehicule" value="<?= $r['id_vehicule'] ?>">
                    <input type="hidden" name="date_debut" value="<?= $r['date_debut'] ?>">
                    <input type="hidden" name="date_fin" value="<?= $r['date_fin'] ?>">
                    <button name="annuler"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Annuler
                    </button>
                </form>

                <!-- Modifier -->
                <form method="POST" class="flex gap-2">
                    <input type="hidden" name="id_vehicule" value="<?= $r['id_vehicule'] ?>">
                    <input type="hidden" name="date_debut" value="<?= $r['date_debut'] ?>">
                    <input type="hidden" name="date_fin" value="<?= $r['date_fin'] ?>">

                    <input type="date" name="new_date_debut" required
                           class="border rounded px-2">
                    <input type="date" name="new_date_fin" required
                           class="border rounded px-2">

                    <button name="modifier"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Modifier
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>

<?php require_once 'Components/footer.php'; ?>
</body>
</html>
