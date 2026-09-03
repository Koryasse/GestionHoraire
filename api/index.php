<?php

// Methode de requête (GET, POST, ...)
$methode = $_SERVER['REQUEST_METHOD'];

// Récupère les données
$body = file_get_contents("php://input");
$bodyData = json_decode($body, true);

// Vérifie id
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Suivant le type de requête
switch ($methode) {
    case "GET":
        $reponse = ;
        break;
    default:
        $reponse = [
            'code' => HTTP_METHOD_NOT_ALLOWED,
            'data' => "La méthode $methode n'est pas supportée."
        ];
        break;
}

// Execute la requete
envoyerReponse($reponse);

/**
 * Traiter une requête GET
 *
 * @param [type] $id
 * @return array
 */
function traiterGet($id) : array {
    if ($id === null) {
        return [
            "code" => HTTP_OK,
            "data" => selectAll()
        ];
    } else if ($id === false || $id <= 0) {
        return [
            "code" => HTTP_BAD_REQUEST,
            "data" => "Nombre entier strictement positif attendu"
        ];
    }
}

?>