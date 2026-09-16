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
 * Lire une classe par son id
 *
 * @param integer $id
 * @return array|false
 */
function getClasseById(int $id): array|false
{
    return dbRun("SELECT * FROM classes WHERE id = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);
}

/**
 * Lire une classe par son nom (ex. I.DA-P3A)
 *
 * @param string $nom
 * @return array|false
 */
function getClasseByNom(string $nom): array|false
{
    return dbRun("SELECT * FROM classes WHERE nom = :nom", [':nom' => $nom])->fetch(PDO::FETCH_ASSOC);
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
 * Modifier une classe
 *
 * @param integer $id
 * @param string $nom
 * @param string $anneeScolaire
 * @return void
 */
function updateClasse(int $id, string $nom, string $anneeScolaire): void
{
    dbRun("UPDATE classes SET nom = :nom, annee_scolaire = :annee_scolaire WHERE id = :id", [':nom' => $nom, ':annee_scolaire' => $anneeScolaire, ':id' => $id]);
}

/**
 * Effacer une classe (les créneaux liés sont aussi effacés)
 *
 * @param integer $id
 * @return void
 */
function deleteClasse(int $id): void
{
    dbRun("DELETE FROM classes WHERE id = :id", [':id' => $id]);
}

?>
