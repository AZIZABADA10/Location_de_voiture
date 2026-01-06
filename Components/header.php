<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="bg-white shadow-sm">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">

        <!-- LEFT -->
        <div class="flex items-center space-x-8">
            <a href="index.php" class="text-2xl font-bold text-blue-600">
                <img src="Assets/logos/logo.png" alt="logo mabagnole" class="w-22 h-16">
            </a>

            <div class="hidden md:flex space-x-6">
                <a href="index.php" class="text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="nos_voitures.php" class="text-gray-700 hover:text-blue-600">Nos voitures</a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="flex items-center space-x-4">

            <?php if (isset($_SESSION['user'])): ?>

                <!-- ADMIN -->
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="Pages/Admin/dashboard.php"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Dashboard
                    </a>

                <!-- CLIENT -->
                <?php else: ?>
                    <a href="espace_client.php"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Mon espace
                    </a>
                <?php endif; ?>

                <!-- LOGOUT -->
                <a href="logout.php"
                   class="px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50">
                    Déconnexion
                </a>

            <?php else: ?>

                <!-- VISITEUR -->
                <a href="login.php"
                   class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">
                    Connexion
                </a>
                <a href="register.php"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Inscription
                </a>

            <?php endif; ?>

        </div>
    </nav>
</header>
