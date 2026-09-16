<?php

require_once "../connexion/db.php";
require_once "../functions/classes.php";

/**
 * Lire tous les créneaux, avec le nom de la classe et du cours
 *
 * @return array Tableau des créneaux
 */
function getAllCreneaux(): array
{
    $query = "SELECT creneaux.*,
                     classes.nom AS classe_nom,
                     cours.code AS cours_code,
                     cours.nom AS cours_nom,
                     TIME_FORMAT(creneaux.heure_debut, '%H:%i') AS heure_debut,
                     TIME_FORMAT(creneaux.heure_fin, '%H:%i') AS heure_fin
              FROM creneaux
              JOIN classes ON creneaux.classe_id = classes.id
              JOIN cours ON creneaux.cours_id = cours.id
              ORDER BY classes.nom,
                       FIELD(creneaux.jour, 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'),
                       creneaux.heure_debut";
    return dbRun($query)->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Lire un créneau par son id, avec le nom de la classe et du cours
 *
 * @param integer $id
 * @return array|false
 */
function getCreneauById(int $id): array|false
{
    $query = "SELECT creneaux.*,
                    classes.nom AS classe_nom,
                    cours.code AS cours_code,
                    cours.nom AS cours_nom,
                    TIME_FORMAT(creneaux.heure_debut, '%H:%i') AS heure_debut,
                    TIME_FORMAT(creneaux.heure_fin, '%H:%i') AS heure_fin
            FROM creneaux
            JOIN classes ON creneaux.classe_id = classes.id
            JOIN cours ON creneaux.cours_id = cours.id
            WHERE creneaux.id = :id";
    return dbRun($query, [':id' => $id])->fetch(PDO::FETCH_ASSOC);
}

/**
 * Lire l'horaire complet d'une classe
 *
 * @param string $nomClasse
 * @return array|null
 */
function getHoraireParClasse(string $nomClasse): array|null
{
    $classe = getClasseByNom($nomClasse);
    if ($classe === false) {
        return null;
    }

    $query = "SELECT creneaux.jour,
                    TIME_FORMAT(creneaux.heure_debut, '%H:%i') AS heure_debut,
                    TIME_FORMAT(creneaux.heure_fin, '%H:%i') AS heure_fin,
                    cours.nom AS cours,
                    cours.code AS code_cours,
                    creneaux.salle
            FROM creneaux
            JOIN cours ON creneaux.cours_id = cours.id
            WHERE creneaux.classe_id = :classe_id
            ORDER BY FIELD(creneaux.jour, 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'), creneaux.heure_debut";
    $horaires = dbRun($query, [':classe_id' => $classe['id']])->fetchAll(PDO::FETCH_ASSOC);

    return [
        "classe" => $classe['nom'],
        "annee_scolaire" => $classe['annee_scolaire'],
        "horaires" => $horaires
    ];
}

/**
 * Ajouter un créneau dans la base de données
 *
 * @param integer $classeId
 * @param integer $coursId
 * @param string $jour
 * @param string $heureDebut
 * @param string $heureFin
 * @param string $salle
 * @return integer L'id du créneau créé
 */
function insertCreneau(int $classeId, int $coursId, string $jour, string $heureDebut, string $heureFin, string $salle): int
{
    $query = "INSERT INTO creneaux (classe_id, cours_id, jour, heure_debut, heure_fin, salle)
            VALUES (:classe_id, :cours_id, :jour, :heure_debut, :heure_fin, :salle)";
    dbRun($query, [':classe_id' => $classeId, ':cours_id' => $coursId, ':jour' => $jour, ':heure_debut' => $heureDebut, ':heure_fin' => $heureFin, ':salle' => $salle]);
    return (int) db()->lastInsertId();
}

/**
 * Modifier un créneau
 *
 * @param integer $id
 * @param integer $classeId
 * @param integer $coursId
 * @param string $jour
 * @param string $heureDebut
 * @param string $heureFin
 * @param string $salle
 * @return void
 */
function updateCreneau(int $id, int $classeId, int $coursId, string $jour, string $heureDebut, string $heureFin, string $salle): void
{
    $query = "UPDATE creneaux
            SET classe_id = :classe_id, cours_id = :cours_id, jour = :jour, heure_debut = :heure_debut, heure_fin = :heure_fin, salle = :salle
            WHERE id = :id";
    dbRun($query, [':classe_id' => $classeId, ':cours_id' => $coursId, ':jour' => $jour, ':heure_debut' => $heureDebut, ':heure_fin' => $heureFin, ':salle' => $salle, ':id' => $id]);
}

/**
 * Effacer un créneau
 *
 * @param integer $id
 * @return void
 */
function deleteCreneau(int $id): void
{
    dbRun("DELETE FROM creneaux WHERE id = :id", [':id' => $id]);
}

?>