<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Vehicule;
use App\Classes\Categorie;
use App\Classes\Reservation;

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}


$vehicule_id = intval($_GET['id']);
$vehicule = null;

$vehicules = Vehicule::listerVehicule(100, 0); 
$categories = Categorie::listerCategorie();

foreach ($vehicules as $v) {
    if ($v['id_vehicule'] == $vehicule_id) {
        $vehicule = $v;
        break;
    }
}

if (!$vehicule) {
    echo "Véhicule introuvable";
    exit;
}


$catNom = '';
foreach ($categories as $c) {
    if ($c['id_categorie'] == $vehicule['id_categorie']) {
        $catNom = $c['titre'];
        break;
    }
}


$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';

    if ($date_debut && $date_fin) {
        $reservation = new Reservation($_SESSION['user']['id'],$vehicule_id,$date_debut,$date_fin);

        if ($reservation->ajouterReservation()) {
            $success = "Votre réservation a été enregistrée avec succès !";
        } else {
            $error = "Erreur lors de la réservation. Veuillez réessayer.";
        }
    } else {
        $error = "Veuillez remplir toutes les dates.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver <?= htmlspecialchars($vehicule['modele']) ?> - MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="index.php" class="text-2xl font-bold text-blue-600">MaBagnole</a>
            <div class="flex items-center space-x-4">
                <a href="nos_voitures.php" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">Retour</a>
            </div>
        </nav>
    </header>

    <!-- Vehicle Info -->
    <section class="py-16">
        <div class="container mx-auto px-4 max-w-3xl bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($vehicule['modele']) ?></h2>
            <p class="text-gray-500 mb-4"><?= htmlspecialchars($catNom) ?></p>
            <img src="<?= htmlspecialchars($vehicule['image']) ?>" alt="<?= htmlspecialchars($vehicule['modele']) ?>" class="w-full h-64 object-cover rounded mb-6">

            <div class="mb-6">
                <span class="text-2xl font-bold text-blue-600"><?= number_format($vehicule['prix_par_jour'], 0, ',', ' ') ?> DH</span>
                <span class="text-gray-500">/jour</span>
            </div>

            <!-- Formulaire de réservation -->
            <?php if ($success): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="date_debut" class="block font-medium mb-1">Date de début :</label>
                    <input type="date" id="date_debut" name="date_debut" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                </div>
                <div>
                    <label for="date_fin" class="block font-medium mb-1">Date de fin :</label>
                    <input type="date" id="date_fin" name="date_fin" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Réserver maintenant
                </button>
            </form>
        </div>
    </section>

    
    <?php require_once 'Components/footer.php';?>

</body>
</html>
