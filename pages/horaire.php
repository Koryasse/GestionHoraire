<?php

require_once "../functions/classes.php";
require_once "../functions/cours.php";
require_once "../functions/creneaux.php";

// Suppression d'un créneau
$deleteId = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($deleteId) {
    deleteCreneau($deleteId);
    header("Location: horaire.php");
    exit;
}

// Ajout d'un créneau
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertCreneau(
        filter_input(INPUT_POST, 'classe_id', FILTER_VALIDATE_INT),
        filter_input(INPUT_POST, 'cours_id', FILTER_VALIDATE_INT),
        filter_input(INPUT_POST, 'jour'),
        filter_input(INPUT_POST, 'heure_debut'),
        filter_input(INPUT_POST, 'heure_fin'),
        filter_input(INPUT_POST, 'salle')
    );
    header("Location: horaire.php");
    exit;
}

$classes = getAllClasses();
$cours = getAllCours();
$creneaux = getAllCreneaux();
$jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Horaire - Horaire</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div>
        <?php include "../includes/header.php"; ?>

        <main class="contenu">
            <div class="form-table-layout">
                <div class="table-section">
                    <h2>Horaire</h2>
                    <table>
                        <tr>
                            <th>Classe</th>
                            <th>Jour</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Cours</th>
                            <th>Salle</th>
                            <th></th>
                        </tr>
                        <?php foreach ($creneaux as $creneau): ?>
                        <tr>
                            <td><?= htmlspecialchars($creneau['classe_nom']) ?></td>
                            <td><?= ucfirst($creneau['jour']) ?></td>
                            <td><?= htmlspecialchars($creneau['heure_debut']) ?></td>
                            <td><?= htmlspecialchars($creneau['heure_fin']) ?></td>
                            <td><?= htmlspecialchars($creneau['cours_code'] . ' - ' . $creneau['cours_nom']) ?></td>
                            <td><?= htmlspecialchars($creneau['salle']) ?></td>
                            <td>
                                <a href="?delete=<?= $creneau['id'] ?>" onclick="return confirm('Supprimer ce créneau ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div class="form-section">
                    <h2>Ajouter un créneau</h2>
                    <form method="post">
                        <label>
                            Classe
                            <select name="classe_id" required>
                                <?php foreach ($classes as $classe): ?>
                                    <option value="<?= $classe['id'] ?>"><?= htmlspecialchars($classe['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>
                            Cours
                            <select name="cours_id" required>
                                <?php foreach ($cours as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['code'] . ' - ' . $c['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>
                            Jour
                            <select name="jour" required>
                                <?php foreach ($jours as $jour): ?>
                                    <option value="<?= $jour ?>"><?= ucfirst($jour) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>
                            Heure de début
                            <input type="time" name="heure_debut" required>
                        </label>
                        <label>
                            Heure de fin
                            <input type="time" name="heure_fin" required>
                        </label>
                        <label>
                            Salle
                            <input type="text" name="salle" required>
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
