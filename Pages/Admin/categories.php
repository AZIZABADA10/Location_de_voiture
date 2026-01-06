<?php
require_once '../Components/TOP_SIDE_BAR.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config\Database;
use App\Classes\Categorie;

if (isset($_POST['ajouter'])) {
    $categorie = new Categorie($_POST['titre'], $_POST['description']);
    $categorie->ajouterCategorie();
}

if (isset($_POST['ajouter_multiple'])) {
    $titres = $_POST['titre'];
    $descriptions = $_POST['description'];

    foreach ($titres as $index => $titre) {
        $categorie = new Categorie(
            $titre,
            $descriptions[$index]
        );
        $categorie->ajouterCategorie();
    }
}


if (isset($_POST['modifier'])) {
    $categorie = new Categorie($_POST['titre'], $_POST['description'], (int)$_POST['id']);
    $categorie->modifierCategorie();
}

if (isset($_GET['supprimer'])) {
    $categorie = new Categorie('', '', (int)$_GET['supprimer']);
    $categorie->supprimerCategorie();
}

$categories = Categorie::listerCategorie();
?>

<main class="p-6">

  <!-- Header + Boutons Ajouter -->
  <div class="flex justify-between items-center mb-6 gap-2">
    <h2 class="text-2xl font-semibold text-gray-800">Gestion des Catégories</h2>
    <div class="flex gap-2">
      <button onclick="document.getElementById('modal-ajouter').classList.remove('hidden')"
              class="px-4 py-2 bg-[#2563EB] text-white rounded hover:bg-[#1E40AF] transition">
        Ajouter une catégorie
      </button>
      <button onclick="document.getElementById('modal-ajouter-multiple').classList.remove('hidden')"
              class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Ajouter plusieurs catégories
      </button>
    </div>
  </div>

  <!-- Table des catégories -->
  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">ID</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Titre</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Description</th>
          <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php foreach ($categories as $cat): ?>
        <tr>
          <td class="px-6 py-4 text-sm text-gray-700"><?= $cat['id_categorie'] ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($cat['titre']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($cat['description']) ?></td>
          <td class="px-6 py-4 text-sm text-right space-x-2">
            <button onclick="ouvrirModifier(<?= $cat['id_categorie'] ?>, '<?= addslashes($cat['titre']) ?>', '<?= addslashes($cat['description']) ?>')"
                    class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
              Modifier
            </button>
            <a href="?supprimer=<?= $cat['id_categorie'] ?>"
               onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')"
               class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
              Supprimer
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal Ajouter une catégorie -->
  <div id="modal-ajouter" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96">
      <h3 class="text-lg font-semibold mb-4">Ajouter une catégorie</h3>
      <form method="POST">
        <div class="mb-4">
          <label class="block mb-1">Titre</label>
          <input type="text" name="titre" required class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
          <label class="block mb-1">Description</label>
          <textarea name="description" required class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="document.getElementById('modal-ajouter').classList.add('hidden')"
                  class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Annuler</button>
          <button type="submit" name="ajouter"
                  class="px-4 py-2 bg-[#2563EB] text-white rounded hover:bg-[#1E40AF] transition">Ajouter</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Ajouter plusieurs catégories -->
  <div id="modal-ajouter-multiple" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-11/12 max-w-4xl overflow-auto max-h-[80vh]">
      <h3 class="text-lg font-semibold mb-4">Ajouter plusieurs catégories</h3>
      <form method="POST">
        <table class="w-full mb-4">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="categories-body">
            <tr>
              <td><input type="text" name="titre[]" required class="border px-2 py-1 w-full"></td>
              <td><input type="text" name="description[]" required class="border px-2 py-1 w-full"></td>
              <td><button type="button" onclick="this.closest('tr').remove()" class="text-red-600">Supprimer</button></td>
            </tr>
          </tbody>
        </table>
        <button type="button" onclick="ajouterLigne()" class="mb-4 px-3 py-1 bg-gray-200 rounded">Ajouter une ligne</button>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="document.getElementById('modal-ajouter-multiple').classList.add('hidden')"
                  class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
          <button type="submit" name="ajouter_multiple"
                  class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Ajouter tous</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Modifier -->
  <div id="modal-modifier" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96">
      <h3 class="text-lg font-semibold mb-4">Modifier la catégorie</h3>
      <form method="POST">
        <input type="hidden" name="id" id="mod-id">
        <div class="mb-4">
          <label class="block mb-1">Titre</label>
          <input type="text" name="titre" id="mod-titre" required class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
          <label class="block mb-1">Description</label>
          <textarea name="description" id="mod-description" required class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="document.getElementById('modal-modifier').classList.add('hidden')"
                  class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Annuler</button>
          <button type="submit" name="modifier"
                  class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">Modifier</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JS -->
  <script>
    let compteur = 1;
    function ajouterLigne() {
      const tbody = document.getElementById('categories-body');
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><input type="text" name="titre[]" required class="border px-2 py-1 w-full"></td>
        <td><input type="text" name="description[]" required class="border px-2 py-1 w-full"></td>
        <td><button type="button" onclick="this.closest('tr').remove()" class="text-red-600">Supprimer</button></td>
      `;
      tbody.appendChild(tr);
      compteur++;
    }

    function ouvrirModifier(id, titre, description) {
      document.getElementById('mod-id').value = id;
      document.getElementById('mod-titre').value = titre;
      document.getElementById('mod-description').value = description;
      document.getElementById('modal-modifier').classList.remove('hidden');
    }
  </script>

</main>
