<?php

require_once "../functions/cours.php";

// Suppression d'un cours
$deleteId = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($deleteId) {
    deleteCours($deleteId);
    header("Location: cours.php");
    exit;
}

// Ajout d'un cours
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = filter_input(INPUT_POST, 'code');
    $nom = filter_input(INPUT_POST, 'nom');
    insertCours($code, $nom);
    header("Location: cours.php");
    exit;
}

$cours = getAllCours();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Horaire - Cours</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div>
        <?php include "../includes/header.php"; ?>

        <main class="contenu">
            <div class="form-table-layout">
                <div class="table-section">
                    <h2>Liste des cours</h2>
                    <table>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th></th>
                        </tr>
                        <?php foreach ($cours as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['code']) ?></td>
                            <td><?= htmlspecialchars($c['nom']) ?></td>
                            <td>
                                <a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce cours ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div class="form-section">
                    <h2>Ajouter un cours</h2>
                    <form method="post">
                        <label>
                            Code du cours (ex. AWEB3)
                            <input type="text" name="code" required>
                        </label>
                        <label>
                            Nom du cours (ex. Atelier Web)
                            <input type="text" name="nom" required>
                        </label>
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
            </div>
        </main>

        <?php include "../includes/footer.php"; ?>
    </div>
</body>
</html>
