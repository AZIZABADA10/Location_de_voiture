<?php
require_once __DIR__ . '/vendor/autoload.php';


use App\Classes\Article;
use App\Classes\Theme;

if(!isset($_GET['id']) || empty($_GET['id'])) {
    die("Thème invalide.");
}

$id_theme = (int)$_GET['id'];

$themeObj = new Theme(null, "", "");
$theme = $themeObj->getThemeById($id_theme);

if(!$theme) {
    die("Thème introuvable.");
}

$articleObj = new Article(null, "", "", true, $id_theme);
$conn = Database::getInstance()->getConnexion();
$stmt = $conn->prepare("SELECT * FROM Article WHERE id_theme = ? AND statut_article = 1");
$stmt->execute([$id_theme]);
$articles = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles du thème : <?= htmlspecialchars($theme->titre) ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .card { 
            border: 1px solid #ccc; 
            padding: 20px; 
            margin: 10px; 
            width: 300px; 
            display: inline-block; 
            vertical-align: top; 
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        .card h3 { margin-top: 0; }
    </style>
</head>
<body>
    <h1>Articles du thème : <?= htmlspecialchars($theme->titre) ?></h1>
    <div class="articles-container">
        <?php if(empty($articles)): ?>
            <p>Aucun article pour ce thème.</p>
        <?php else: ?>
            <?php foreach($articles as $article): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($article->titre) ?></h3>
                    <p><?= nl2br(htmlspecialchars(substr($article->contenu,0,150))) ?>...</p>
                    <a href="article_detail.php?id=<?= $article->id_article ?>">Voir plus</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
