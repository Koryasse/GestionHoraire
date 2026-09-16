<?php

// Détermine le préfixe des liens selon que la page est à la racine ou dans pages/
$_info = (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false) ? ".." : ".";

?>
<header>
    <nav>
        <h1>Gestion Horaire</h1>
        <div>
            <a href="<?= $_info ?>/index.php" data-page="home">Accueil</a>
            <a href="<?= $_info ?>/pages/cours.php" data-page="cours">Cours</a>
            <a href="<?= $_info ?>/pages/classes.php" data-page="classes">Classes</a>
            <a href="<?= $_info ?>/pages/horaire.php" data-page="creneaux">Créneaux</a>
        </div>
    </nav>
</header>