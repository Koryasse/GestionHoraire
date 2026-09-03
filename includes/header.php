<?php 

$_info = __DIR__ == "includes" ? ".." : ".";

?>
<header>
    <h1>Gestion Horaire</h1>
    <nav>
        <a href="<?= $_info ?>/index.php" data-page="home">Accueil</a>
        <a href="<?= $_info ?>/pages/cours.php" data-page="cours">Cours</a>
        <a href="<?= $_info ?>/pages/classes.php" data-page="classes">Classes</a>
        <a href="<?= $_info ?>/pages/horaire.php" data-page="creneaux">Créneaux</a>
    </nav>
</header>