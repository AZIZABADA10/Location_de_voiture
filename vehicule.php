<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Vehicule;
use App\Classes\Avis;

$idVehicule = $_GET['id'] ?? null;
if (!$idVehicule) {
    header('Location: nos_voitures.php');
    exit;
}

$vehicule = Vehicule::trouverVehiculeParId((int)$idVehicule);
if (!$vehicule) {
    header('Location: nos_voitures.php');
    exit;
}

$avis = Avis::avisParVehicule((int)$idVehicule);

$userId = $_SESSION['user']['id'] ?? null;
$monAvis = null;

// Vérifie si l'utilisateur a déjà un avis
if ($userId) {
    $monAvis = Avis::avisUtilisateur((int)$idVehicule, (int)$userId);
}

// POST : ajout ou modification ou suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userId) {
    if (isset($_POST['commentaire'])) {
        $commentaire = trim($_POST['commentaire']);
        if ($commentaire !== '') {
            if ($monAvis) {
                Avis::modifierAvis((int)$idVehicule, (int)$userId, $commentaire);
            } else {
                Avis::ajouterAvis((int)$idVehicule, (int)$userId, $commentaire);
            }
            header("Location: vehicule.php?id=$idVehicule&success=1");
            exit;
        }
    }

    if (isset($_POST['delete_avis'])) {
        Avis::supprimerAvis((int)$idVehicule, (int)$userId);
        header("Location: vehicule.php?id=$idVehicule&deleted=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails véhicule</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<?php require_once 'Components/header.php'; ?>

<section class="container mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">

    <!-- IMAGE -->
    <img src="<?= htmlspecialchars($vehicule['image']) ?>" class="w-full rounded-lg shadow">

    <!-- INFOS -->
    <div>
        <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($vehicule['modele']) ?></h1>
        <p class="text-gray-500 mb-4">Marque : <?= htmlspecialchars($vehicule['marque']) ?></p>
        <p class="text-2xl font-bold text-blue-600 mb-6">
            <?= number_format($vehicule['prix_par_jour'], 0, ',', ' ') ?> DH / jour
        </p>
        <a href="reserver.php?id=<?= $vehicule['id_vehicule'] ?>"
           class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
            Louer ce véhicule
        </a>
    </div>

</section>

<!-- AVIS -->
<section class="container mx-auto px-4 pb-16">
    <h2 class="text-2xl font-bold mb-6">Avis clients</h2>

    <?php if (empty($avis)): ?>
        <p class="text-gray-500">Aucun avis pour ce véhicule.</p>
    <?php endif; ?>

    <?php foreach ($avis as $a): ?>
        <div class="bg-white p-4 rounded shadow mb-4">
            <p class="font-semibold"><?= htmlspecialchars($a['nom']) ?></p>
            <p class="text-gray-600 text-sm"><?= $a['date_avis'] ?></p>
            <p class="mt-2"><?= nl2br(htmlspecialchars($a['commentaire'])) ?></p>

            <?php if ($userId && $userId == $a['id_utilisateur']): ?>
                <div class="flex gap-2 mt-2">
                    <!-- Bouton modifier : met le commentaire dans le formulaire -->
                    <button type="button" class="text-blue-600 text-sm"
                        onclick="document.getElementById('commentaireInput').value = '<?= addslashes($a['commentaire']) ?>';">
                        Modifier
                    </button>

                    <!-- Bouton supprimer -->
                    <form method="POST">
                        <input type="hidden" name="delete_avis" value="1">
                        <button class="text-red-600 text-sm">Supprimer</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <!-- FORMULAIRE AVIS -->
    <?php if ($userId): ?>
        <form method="POST" class="mt-6 bg-white p-4 rounded shadow">
            <textarea id="commentaireInput" name="commentaire"
                      required
                      class="w-full border rounded p-3"
                      placeholder="Donnez votre avis..."><?= htmlspecialchars($monAvis['commentaire'] ?? '') ?></textarea>

            <button class="mt-3 bg-blue-600 text-white px-6 py-2 rounded">
                <?= $monAvis ? "Modifier l’avis" : "Publier l’avis" ?>
            </button>
        </form>
    <?php else: ?>
        <p class="mt-4 text-red-500">
            Connectez-vous pour laisser un avis.
        </p>
    <?php endif; ?>
</section>

<?php require_once 'Components/footer.php'; ?>

</body>
</html>
