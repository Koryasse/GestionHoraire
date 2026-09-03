<?php

require_once "../connexion/db.php";

/**
 * Lire tous les scores
 *
 * @return array Tableau des scores
 */
function selectAll() : array
{
    $query = "SELECT ";
    $param = [];
    return dbRun($query, $param)->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Ajouter un score dans la base de données
 *
 * @param  string  $playerName Nom du joueur
 * @param  string  $gameName   Nom du jeu
 * @param  integer $score      Score obtenu
 */
function insert(string $playerName, string $gameName, int $score) : void
{
    $query = "INSERT INTO ";
    $param = [
        
    ];
    dbRun($query, $param);
}

/**
 * Effacer
 *
 * @param int $id
 */
function delete(int $id) : void
{
    $query = "DELETE FROM ";
    $param = [ ];
    dbRun($query, $param);
}

?>