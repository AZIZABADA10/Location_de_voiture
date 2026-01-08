<?php
require_once __DIR__ . '/vendor/autoload.php';


use App\Classes\Article;

if(!isset($_GET['id']) || empty($_GET['id'])) {
    die("Article invalide.");
}

$id_article = (int)$_GET['id'];

$articleObj = new Article(null, "", "", true, 0);
$article = $articleObj->getArticleById($id_article);

if(!$article) {
    die("Article introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article->titre) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($article->titre) ?></h1>
    <p><?= nl2br(htmlspecialchars($article->contenu)) ?></p>
    <a href="nos_themes.php">Retour aux thèmes</a>
</body>
</html>
