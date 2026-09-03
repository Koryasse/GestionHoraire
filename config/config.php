<?php 

define('DB_HOST', 'localhost');
define('DB_NAME', 'GestionHoraire');
define('DB_CHAR', 'utf8');
define('DB_USER', 'yassine');
define('DB_PASS', 'super');

// Code de succès
define("HTTP_OK", 200);
define("HTTP_CREATED", 201);
define("HTTP_NO_CONTENT", 204);

// Code d'erreur client
define("HTTP_BAD_REQUEST", 400);
define("HTTP_UNAUTHORIZED", 402);
define("HTTP_FORBIDDEN", 403);
define("HTTP_NOT_FOUND", 404);
define("HTTP_METHOD_NOT_ALLOWED", 405);
define("HTTP_TEA_POT", 418);

// Code d'erreur serveur
define("HTTP_INTERNAL_ERROR", 500);

/**
 * Indique si le code HTTP correspond à un succès
 *
 * @param integer $code Le code à$ valider
 * @return boolean true si succès, false si échec
 */
function isSuccess(int $code): bool
{
    return $code >= 200 && $code < 300;
}

/**
 * Lire les données JSON transmises dans le corps de la requête HTTP
 *
 * @return array Un tableau avec les données JSON structurées
 */
function lireDonneeBody(): array
{
    $body = file_get_contents("php://input");
    if ($body === false || $body === "") {
        return [];
    }

    $json = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $json;
}

/**
 * Envoyer la réponse HTTP, puis terminer le programme
 *
 * @param array $reponse Le tablea de réponse (data, code)
 * @return void
 */
function envoyerReponse(array $reponse): void
{
    http_response_code($reponse['code'] ?? HTTP_OK);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($reponse['data'] ?? null);
    die();
}

?>