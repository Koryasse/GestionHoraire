<?php

require_once "../connexion/db.php";

/**
 * Lire tous les cours
 *
 * @return array Tableau des cours
 */
function getAllCours(): array
{
    return dbRun("SELECT * FROM cours ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Lire un cours par son id
 *
 * @param integer $id
 * @return array|false
 */
function getCoursById(int $id): array|false
{
    return dbRun("SELECT * FROM cours WHERE id = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);
}

/**
 * Ajouter un cours dans la base de données
 *
 * @param string $code
 * @param string $nom
 * @return integer L'id du cours créé
 */
function insertCours(string $code, string $nom): int
{
    dbRun("INSERT INTO cours (code, nom) VALUES (:code, :nom)", [':code' => $code, ':nom' => $nom]);
    return (int) db()->lastInsertId();
}

/**
 * Modifier un cours
 *
 * @param integer $id
 * @param string $code
 * @param string $nom
 * @return void
 */
function updateCours(int $id, string $code, string $nom): void
{
    dbRun("UPDATE cours SET code = :code, nom = :nom WHERE id = :id", [':code' => $code, ':nom' => $nom, ':id' => $id]);
}

/**
 * Effacer un cours (les créneaux liés sont aussi effacés)
 *
 * @param integer $id
 * @return void
 */
function deleteCours(int $id): void
{
    dbRun("DELETE FROM cours WHERE id = :id", [':id' => $id]);
}

?>
