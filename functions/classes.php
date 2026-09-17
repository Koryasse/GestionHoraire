<?php

require_once "../connexion/db.php";

/**
 * Lire toutes les classes
 *
 * @return array Tableau des classes
 */
function getAllClasses(): array
{
    return dbRun("SELECT * FROM classes ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Ajouter une classe dans la base de données
 *
 * @param string $nom
 * @param string $anneeScolaire
 * @return integer L'id de la classe créée
 */
function insertClasse(string $nom, string $anneeScolaire): int
{
    dbRun("INSERT INTO classes (nom, annee_scolaire) VALUES (:nom, :annee_scolaire)", [':nom' => $nom, ':annee_scolaire' => $anneeScolaire]);
    return (int) db()->lastInsertId();
}

/**
 * Modifie une classe dans une base de données
 * @param string $nom
 * @param string $anneeScolaire
 * @param int $id
 * @return void
 */
function putClasse(string $nom, string $anneeScolaire, int $id) {
    dbRun("UPDATE classes SET nom = :nom, annee_scolaire = :annee_scolaire WHERE id = :id", [':nom' => $nom, ':anne_scolaire' => $anneeScolaire, ':id' => $id]);
}

/**
 * Effacer une classe
 *
 * @param integer $id
 * @return void
 */
function deleteClasse(int $id): void
{
    dbRun("DELETE FROM classes WHERE id = :id", [':id' => $id]);
}

?>
