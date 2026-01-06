<?php if (empty($vehicules)): ?>
    <p class="col-span-4 text-center text-gray-500">
        Aucun véhicule trouvé
    </p>
<?php endif; ?>

<?php foreach ($vehicules as $v): ?>
<div class="bg-white rounded-lg shadow hover:shadow-xl transition">
    <img src="<?= htmlspecialchars($v['image']) ?>"
         class="w-full h-48 object-cover rounded-t-lg">

    <div class="p-4">
        <h3 class="font-bold text-lg"><?= htmlspecialchars($v['modele']) ?></h3>
        <p class="text-gray-500 text-sm"><?= htmlspecialchars($v['marque']) ?></p>

        <div class="flex justify-between items-center mt-4">
            <span class="text-xl font-bold text-blue-600">
                <?= number_format($v['prix_par_jour'], 0, ',', ' ') ?> DH
            </span>

            <a href="../reserver.php?id=<?= $v['id_vehicule'] ?>"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Louer
            </a>
        </div>
    </div>
</div>
<?php endforeach; ?>
