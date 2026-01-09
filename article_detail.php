<?php
require_once __DIR__ . '/vendor/autoload.php';


use App\Classes\Article;

$id_article = (int)$_GET['id'];
$article = Article::getArticleById($id_article);



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
    <a href="nos_article.php">Retour aux thèmes</a>
</body>
</html>
