<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Classes\Theme;


$themes = Theme::getAllTheme();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Thèmes - MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen">

<?php require_once 'Components/header.php'; ?>

<!-- HERO -->
<section class="relative py-20 bg-gradient-to-r from-blue-600 to-indigo-600 text-center text-white">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
            Nos Thèmes du Blog
        </h1>
        <p class="text-blue-100 text-lg">
            Explorez nos catégories et découvrez des articles inspirants
        </p>
    </div>
</section>

<!-- THEMES -->
<section class="max-w-6xl mx-auto px-6 py-20">
    <div class="grid gap-10 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-center items-center">
        
        <?php foreach ($themes as $theme): ?>
            <div
                class="group bg-white rounded-3xl p-8 w-full max-w-sm
                       shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 mx-auto"
            >

                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl font-bold">
                    #
                </div>

                <h3 class="text-2xl font-bold text-gray-800 text-center mb-3 group-hover:text-blue-600 transition">
                    <a href="articles_par_theme.php?id=<?= $theme->id_theme ?>">
                        <?= htmlspecialchars($theme->titre) ?>
                    </a>
                </h3>

                <p class="text-gray-500 text-base text-center mb-8">
                    <?= htmlspecialchars(substr($theme->description, 0, 110)) ?>...
                </p>

                <div class="text-center">
                    <a
                        href="articles_par_theme.php?id=<?= $theme->id_theme ?>"
                        class="inline-flex items-center px-6 py-3 rounded-full
                               bg-blue-600 text-white text-base font-semibold
                               hover:bg-blue-700 transition"
                    >
                        Voir les articles →
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>

<?php require_once 'Components/footer.php'; ?>

</body>
</html>
