<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
use App\Classes\Utilisateur;

$errorMessage = '';

if (isset($_POST['connecter'])) {
    $result = Utilisateur::login($_POST['email'], $_POST['mot_de_passe']);

    if (!$result['success']) {
        $errorMessage = $result['message'];
    } else {
        $role = $_SESSION['user']['role'] ?? 'client';
        if ($role === 'admin') {
            header('Location: Pages/Admin/dashboard.php');
            exit();
        } else {
            header('Location: nos_voitures.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="Assets/logos/logo.png" type="image/x-icon">
</head>

<body class="min-h-screen bg-gradient-to-tr from-blue-900 via-blue-800 to-blue-700 flex items-center justify-center font-sans">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden">
        <!-- Decoration Background Circles -->
        <div class="absolute -top-16 -right-16 w-40 h-40 bg-blue-200 rounded-full opacity-20"></div>
        <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-blue-300 rounded-full opacity-20"></div>

        <!-- Logo & Title -->
        <div class="text-center mb-6 relative z-10">
            <img src="Assets/logos/logo.png" class="mx-auto h-16 mb-3" alt="logo">
            <h1 class="text-3xl font-bold text-blue-600">Connexion</h1>
            <p class="text-gray-500 mt-1">Accédez à votre compte</p>
        </div>

        <!-- Error Message -->
        <?php if (!empty($errorMessage)) : ?>
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded relative z-10">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form class="space-y-5 relative z-10" action="login.php" method="POST">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" placeholder="exemple@email.com"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Mot de passe</label>
                <input type="password" name="mot_de_passe" placeholder="••••••••"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 outline-none">
            </div>

            <button name="connecter"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3 rounded-lg font-semibold shadow-md hover:shadow-lg hover:from-blue-700 hover:to-blue-600 transition duration-300">
                Se connecter
            </button>
        </form>

        <!-- Footer Links -->
        <div class="text-center mt-6 text-sm text-gray-600 relative z-10">
            Pas encore de compte ?
            <a href="register.php" class="text-blue-600 font-semibold hover:underline">Inscription</a>
        </div>
        <div class="text-center mt-2 text-sm text-gray-600 relative z-10">
            <a href="index.php" class="text-blue-600 font-semibold hover:underline">Accueil</a>
        </div>
    </div>

</body>
</html>
