<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Config\Database;
use App\Classes\Article;
use App\Classes\Theme;
use App\Classes\Tag;

$id_theme = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$search = $_GET['search'] ?? '';
$tag_filter = isset($_GET['tag']) && $_GET['tag'] !== '' ? (int)$_GET['tag'] : null;

$theme = Theme::getThemeById($id_theme);
if (!$theme) die('Thème introuvable.');

$articles = Article::getAllArticleByTheme($id_theme, $search, $tag_filter);
$allTags = Tag::getAllTag();


           

require_once 'Components/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles du thème : <?= htmlspecialchars($theme->titre) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<!-- HERO -->
<section class="py-12 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center">
    <h1 class="text-4xl font-bold mb-2"><?= htmlspecialchars($theme->titre) ?></h1>
    <p class="text-blue-100 text-lg">Découvrez les articles liés à ce thème</p>
</section>

<!-- FILTRE & RECHERCHE -->
<section class="max-w-6xl mx-auto px-6 py-10">
<form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
    <input type="hidden" name="id" value="<?= $id_theme ?>"> 
    <div class="flex gap-4 flex-1">
        <input type="text" name="search" placeholder="Rechercher un article..." 
               value="<?= htmlspecialchars($search) ?>"
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <select name="tag" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filtrer par tag</option>
            <?php foreach ($allTags as $tag): ?>
                <option value="<?= $tag->id_tag ?>" <?= $tag_filter == $tag->id_tag ? 'selected' : '' ?>>
                    Tag #<?= htmlspecialchars($tag->tag) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Rechercher
    </button>
</form>


    <!-- ARTICLES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
        <?php if(empty($articles)): ?>
            <p class="text-gray-500 col-span-full text-center">Aucun article trouvé pour ce thème.</p>
        <?php else: ?>
            <?php foreach($articles as $article): ?>
                <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-sm hover:shadow-2xl transition">
                    <h3 class="text-2xl font-bold mb-2"><?= htmlspecialchars($article->titre) ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?= nl2br(htmlspecialchars(mb_substr($article->contenu,0,150))) ?>...
                    </p>
                    <a href="article_detail.php?id=<?= $article->id_article ?>"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Voir plus
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'Components/footer.php'; ?>
</body>
</html>
