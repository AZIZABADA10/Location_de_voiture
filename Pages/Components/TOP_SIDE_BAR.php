<?php
session_start();
$nom_admin = $_SESSION['user']['nom'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MaBagnole Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="../../Assets/logos/logo.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../Assets/style.css">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .menu-item {
      @apply flex items-center gap-3 px-4 py-3 rounded-lg
             text-gray-300 hover:bg-[#2563EB]/20 hover:text-white transition-all duration-200;
    }
    .menu-item svg {
      @apply w-5 h-5 text-gray-400;
    }
    .menu-item:hover svg {
      @apply text-white;
    }
    .menu-item-active {
      @apply bg-[#2563EB] text-white;
    }
    .menu-item-active svg {
      @apply text-white;
    }
  </style>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">
<aside class="w-64 bg-[#0F172A] text-white hidden md:flex flex-col">
  <!-- Logo -->
  <div class="p-5 text-2xl font-bold text-center border-b border-gray-700 flex items-center justify-center gap-2">
    <img src="../../Assets/logos/logo.png" class="w-14 h-12">
    <span>Ma<span class="text-[#2563EB]">Bagnole</span></span>
  </div>

  <!-- Navigation -->
  <nav class="flex-1 p-5 flex flex-col gap-3">
    <!-- Dashboard -->
    <a href="Dashboard.php" class="flex items-center gap-3 p-2 rounded hover:bg-[#1E293B] hover:text-[#2563EB] transition-colors">
      <i class='bx bx-home text-xl'></i>
      <span>Dashboard</span>
    </a>

    <!-- Véhicules -->
    <a href="vehicles.php" class="flex items-center gap-3 p-2 rounded hover:bg-[#1E293B] hover:text-[#2563EB] transition-colors">
      <i class='bx bxs-car text-xl'></i>
      <span>Véhicules</span>
    </a>

    <!-- Catégories -->
    <a href="categories.php" class="flex items-center gap-3 p-2 rounded hover:bg-[#1E293B] hover:text-[#2563EB] transition-colors">
      <i class='bx bx-category text-xl'></i>
      <span>Catégories</span>
    </a>

    <!-- Réservations -->
    <a href="reservations.php" class="flex items-center gap-3 p-2 rounded hover:bg-[#1E293B] hover:text-[#2563EB] transition-colors">
      <i class='bx bx-calendar-check text-xl'></i>
      <span>Réservations</span>
    </a>

    <!-- Avis -->
    <a href="reviews.php" class="flex items-center gap-3 p-2 rounded hover:bg-[#1E293B] hover:text-[#2563EB] transition-colors">
      <i class='bx bxs-star text-xl'></i>
      <span>Avis</span>
    </a>
    <a href="../../logout.php" 
      class="flex items-center gap-2 px-4 py-2 mt-40 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
      <i class='bx bx-log-out text-lg'></i>
      <span>Déconnexion</span>
    </a>

  </nav>
    
</aside>



  <!-- MAIN -->
  <div class="flex-1 flex flex-col">

    <!-- TOPBAR -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">

      <!-- LEFT -->
      <div class="flex items-center gap-4">
        <h1 class="text-xl font-semibold text-gray-800 tracking-tight">Dashboard</h1>
      </div>

      <!-- RIGHT -->
      <div class="flex items-center gap-6">

        <!-- Profile -->
        <div class="relative group cursor-pointer">
          <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 transition">
            <img src="https://media.licdn.com/dms/image/v2/D4E03AQElm7ulvGwwmg/profile-displayphoto-crop_800_800/B4EZgFhiIBGcAI-/0/1752439336799?e=1769040000&v=beta&t=DCbs9vn7MfTkRKTp6ql521Zxsi6r3Lu6vpmsGcWPUhc" class="w-9 h-9 rounded-full object-cover">
            <div class="hidden md:block">
              <p class="text-xl text-gray-500"><?=
                
                $nom_admin
                ?>
                </p>
            </div>
          </div>

        </div>

      </div>
    </header>