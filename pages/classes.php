<?php

require_once "../functions/classes.php";

// Suppression d'une classe
$deleteId = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($deleteId) {
    deleteClasse($deleteId);
    header("Location: classes.php");
    exit;
}

// Ajout d'une classe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
    $anneeScolaire = filter_input(INPUT_POST, 'annee_scolaire', FILTER_SANITIZE_SPECIAL_CHARS);
    insertClasse($nom, $anneeScolaire);
    header("Location: classes.php");
    exit;
}

$classes = getAllClasses();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Horaire - Classes</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div>
        <?php include "../includes/header.php"; ?>

        <main class="contenu">
            <div class="form-table-layout">
                <div class="table-section">
                    <h2>Liste des classes</h2>
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Année scolaire</th>
                            <th></th>
                        </tr>
                        <?php foreach ($classes as $classe): ?>
                        <tr>
                            <td><?= htmlspecialchars($classe['nom']) ?></td>
                            <td><?= htmlspecialchars($classe['annee_scolaire']) ?></td>
                            <td>
                                <a class="deleteBtn" href="?delete=<?= $classe['id'] ?>" onclick="return confirm('Supprimer cette classe ?')">Supprimer</a>
                                <span> | </span>
                                <a class="putBtn" href="?put=<?= $classe['id'] ?>">Modifier</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div class="form-section">
                    <h2>Ajouter une classe</h2>
                    <form method="post">
                        <label>
                            Nom de la classe (ex. I.DA-P3A)
                            <input type="text" name="nom" required>
                        </label>
                        <label>
                            Année scolaire (ex. 2026-2027)
                            <input type="text" name="annee_scolaire" required>
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
