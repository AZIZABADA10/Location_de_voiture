<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Vehicule;
use App\Classes\Categorie;


$page = $_GET['page'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$vehicules = Vehicule::listerVehicule($limit, $offset);
$categories = Categorie::listerCategorie();
$totalPages = ceil(Vehicule::count() / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Voitures - MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<?php require_once 'Components/header.php'; ?>

<!-- HERO -->
<section class="py-16 bg-blue-50 text-center">
    <h1 class="text-4xl font-bold mb-4">Découvrez notre parc automobile</h1>
    <p class="text-gray-600">Recherchez, filtrez et louez facilement</p>
</section>

<!-- RECHERCHE -->
<div class="container mx-auto px-4 mt-10">
    <input type="text"
           id="searchInput"
           placeholder=" Rechercher par modèle ou marque..."
           class="w-full md:w-1/2 mx-auto block px-4 py-3 border rounded-lg shadow">
</div>

<!-- CATEGORIES -->
<div class="container mx-auto px-4 mt-6 flex flex-wrap gap-3 justify-center">
    <button onclick="filtrerCategorie(0)"
            class="px-4 py-2 rounded bg-blue-600 text-white">
        Toutes
    </button>

    <?php foreach ($categories as $c): ?>
        <button onclick="filtrerCategorie(<?= $c['id_categorie'] ?>)"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-blue-100">
            <?= htmlspecialchars($c['titre']) ?>
        </button>
    <?php endforeach; ?>
</div>

<!-- VEHICULES -->
<section class="container mx-auto px-4 py-12">
    <div id="vehiculesContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

        <?php foreach ($vehicules as $v): ?>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                
                <!-- Image avec effet zoom -->
                <div class="h-52 overflow-hidden">
                    <img src="<?= htmlspecialchars($v['image']) ?>" 
                         alt="<?= htmlspecialchars($v['modele']) ?>"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Contenu -->
                <div class="p-5 flex flex-col justify-between h-56">
                    <div>
                        <h3 class="font-semibold text-lg text-gray-800 mb-2">
                            <?= htmlspecialchars($v['modele']) ?>
                        </h3>
                        <p class="text-gray-400 text-sm mb-4">
                            <?= htmlspecialchars($v['marque']) ?>
                        </p>
                    </div>

                    <!-- Prix et actions -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-2xl font-bold text-blue-600">
                            <?= number_format($v['prix_par_jour'], 0, ',', ' ') ?> DH
                        </span>

                        <div class="flex flex-col gap-2">
                            <a href="reserver.php?id=<?= $v['id_vehicule'] ?>"
                               class="bg-blue-600 text-white px-5 py-2 rounded-xl font-medium text-sm text-center hover:bg-blue-700 transition">
                                Louer
                            </a>
                            <a href="vehicule.php?id=<?= $v['id_vehicule'] ?>"
                               class="text-blue-600 text-sm hover:underline text-center">
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

    </div>
</section>



<div class="flex justify-center gap-2 pb-12">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>"
           class="px-4 py-2 border rounded
           <?= $i == $page ? 'bg-blue-600 text-white' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

<?php require_once 'Components/footer.php'; ?>


<script>

document.getElementById('searchInput').addEventListener('keyup', function () {
    fetch('ajax/rechercheVehicule.php?q=' + this.value)
        .then(res => res.text())
        .then(html => {
            document.getElementById('vehiculesContainer').innerHTML = html;
        });
});

function filtrerCategorie(id) {
    fetch('ajax/filtrerCategorie.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('vehiculesContainer').innerHTML = html;
        });
}
</script>

</body>
</html>
