<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Theme;

$themeObj = new Theme(null, "", "");
$themes = $themeObj->getAllTheme();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Thèmes - MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<?php require_once 'Components/header.php'; ?>

<!-- HERO -->
<section class="py-16 bg-blue-50 text-center">
    <h1 class="text-4xl font-bold mb-4">Nos Thèmes du Blog</h1>
    <p class="text-gray-600">Cliquez sur un thème pour découvrir les articles associés</p>
</section>

<!-- THÈMES -->
<section class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php foreach ($themes as $theme): ?>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                
                <!-- Contenu de la carte -->
                <div class="p-5 flex flex-col justify-between h-40">
                    <h3 class="font-semibold text-lg text-gray-800 mb-2 text-center">
                        <a href="articles_par_theme.php?id=<?= $theme->id_theme ?>" class="hover:text-blue-600 transition">
                            <?= htmlspecialchars($theme->titre) ?>
                        </a>
                    </h3>
                    <p class="text-gray-400 text-sm text-center">
                        <?= htmlspecialchars(substr($theme->description, 0, 80)) ?>...
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'Components/footer.php'; ?>

</body>
</html>
