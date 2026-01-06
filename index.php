<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Vehicule;
use App\Classes\Categorie;

$vehicules = Vehicule::listerVehicule(4, 0);
$categories = Categorie::listerCategorie();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location de Voiture - Simple et Abordable</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="Assets/logos/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans">
    <!-- Header -->
        <?php require_once 'Components/header.php';?>

    <!-- Hero Section -->
    <section class="relative py-40 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 via-blue-800/80 to-transparent"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                        <span class="text-white drop-shadow-2xl">Location simple</span><br>
                        <span class="text-white drop-shadow-2xl">et </span>
                        <span class="bg-gradient-to-r from-blue-600 via-red-600 to-cyan-300 bg-clip-text text-transparent drop-shadow-lg">Abordable</span>
                    </h1>
                    <p class="text-lg text-blue-50 leading-relaxed">
                        Louez une voiture en quelques clics et profitez de tarifs compétitifs pour tous vos déplacements au Maroc
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Louez avec les trois étapes suivantes</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Renseignez-vous Aussi</h3>
                    <p class="text-gray-600">Choisissez votre destination et les dates de location</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Choisissez votre véhicul</h3>
                    <p class="text-gray-600">Sélectionnez le véhicule qui correspond à vos besoins</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-car text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Véhicule je garantis!</h3>
                    <p class="text-gray-600">Profitez de votre véhicule en toute sérénité</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center items-center gap-12 opacity-60">
                <img src="https://logos-world.net/wp-content/uploads/2021/03/Honda-Logo.png" alt="Honda" class="h-8 grayscale">
                <img src="https://logos-world.net/wp-content/uploads/2021/04/Jaguar-Logo.png" alt="Jaguar" class="h-8 grayscale">
                <img src="Assets/logos/nissan.png" alt="Nissan" class="h-8 grayscale">
                <img src="https://logos-world.net/wp-content/uploads/2021/03/Volvo-Logo.png" alt="Volvo" class="h-8 grayscale">
                <img src="Assets/logos/audi.png" alt="Audi" class="h-8 grayscale">
                <img src="Assets/logos/Alfa-Romeo-logo.png" alt="Alfa Romeo" class="h-8 grayscale">
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800" alt="Audi R8" class="ml-40 w-[400px] h-[400px] rounded-lg shadow-xl">
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-6">Votre location de voiture urbaine ou familiale.</h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shield-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Différents types de voitures</h3>
                                <p class="text-gray-600 text-sm">Large sélection de véhicules adaptés à tous vos besoins</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Pas de frais cachés</h3>
                                <p class="text-gray-600 text-sm">Transparence totale sur tous nos tarifs</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-tags text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Flexibilité</h3>
                                <p class="text-gray-600 text-sm">Modifiez ou annulez votre réservation facilement</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-headset text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Tarifs abordables</h3>
                                <p class="text-gray-600 text-sm">Les meilleurs prix du marché garantis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Cars Section -->
    <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">
            Trouvez la voiture qui vous convient en consultant notre
        </h2>
        <p class="text-center text-gray-600 mb-12">parc dans les Marchés suivants</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($vehicules as $v):
                $catNom = '';
                foreach ($categories as $c) {
                    if ($c['id_categorie'] == $v['id_categorie']) {
                        $catNom = $c['titre'];
                        break;
                    }
                }
            ?>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                <!-- Image -->
                <div class="h-52 overflow-hidden">
                    <img src="<?= htmlspecialchars($v['image']) ?>" 
                        alt="<?= htmlspecialchars($v['modele']) ?>" 
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Contenu -->
                <div class="p-5 flex flex-col justify-between h-56">
                    <div>
                        <h3 class="font-semibold text-xl mb-2 text-gray-800"><?= htmlspecialchars($v['modele']) ?></h3>
                        <p class="text-gray-400 text-sm mb-4"><?= htmlspecialchars($catNom) ?></p>
                    </div>

                    <!-- Prix et actions -->
                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-blue-600"><?= number_format($v['prix_par_jour'], 0, ',', ' ') ?> DH</span>
                            <span class="text-gray-400 text-sm">/jour</span>
                        </div>
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

        <div class="text-center mt-8">
            <a href="nos_voitures.php" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Afficher tous les véhicules
            </a>
        </div>
    </div>
</section>

    <!-- Morocco Map Section -->
    <section class="py-16 bg-blue-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Découvrez nos différentes implantations au Maroc</h2>
            <div class="max-w-2xl mx-auto">
                <img src="Assets/logos/Carte_du_Maroc.png" alt="Carte du Maroc" class="w-full h-auto">
            </div>
        </div>
    </section>

    <?php require_once 'Components/footer.php';?>
    
</body>
</html>