<?php

require_once "../config/config.php";
require_once "../functions/classes.php";
require_once "../functions/cours.php";
require_once "../functions/creneaux.php";

// Methode de requête (GET, POST, PUT, DELETE, ...)
$methode = $_SERVER['REQUEST_METHOD'];

// Ressource demandée (classes, cours ou creneaux)
$ressource = filter_input(INPUT_GET, "resource", FILTER_SANITIZE_STRING) ?? '';

// Vérifie id
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Données JSON envoyées dans le corps de la requête (POST / PUT)
$donnees = lireDonneeBody();

// Suivant la ressource demandée
switch ($ressource) {
    case "classes":
        $reponse = traiterClasses($methode, $id, $donnees);
        break;
    case "cours":
        $reponse = traiterCours($methode, $id, $donnees);
        break;
    case "creneaux":
        $reponse = traiterCreneaux($methode, $id, $donnees);
        break;
    default:
        $reponse = [
            "code" => HTTP_NOT_FOUND,
            "data" => "Ressource inconnue. Utilisez ?resource=classes, ?resource=cours ou ?resource=creneaux"
        ];
}

// Envoie la réponse
envoyerReponse($reponse);

/**
 * Traiter une requête sur la ressource "classes"
 *
 * @param string $methode
 * @param integer|false|null $id
 * @param array $donnees
 * @return array
 */
function traiterClasses(string $methode, int|false|null $id, array $donnees): array
{
    switch ($methode) {
        case "GET":
            if ($id === null) {
                return ["code" => HTTP_OK, "data" => getAllClasses()];
            }
            if ($id === false) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id invalide"];
            }
            $classe = getClasseById($id);
            if ($classe === false) {
                return ["code" => HTTP_NOT_FOUND, "data" => "Classe introuvable"];
            }
            return ["code" => HTTP_OK, "data" => $classe];

        case "POST":
            $nouvelId = insertClasse($donnees['nom'] ?? '', $donnees['annee_scolaire'] ?? '');
            return ["code" => HTTP_CREATED, "data" => getClasseById($nouvelId)];

        case "PUT":
            if (!$id) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id requis"];
            }
            updateClasse($id, $donnees['nom'] ?? '', $donnees['annee_scolaire'] ?? '');
            return ["code" => HTTP_OK, "data" => getClasseById($id)];

        case "DELETE":
            if (!$id) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id requis"];
            }
            deleteClasse($id);
            return ["code" => HTTP_NO_CONTENT, "data" => null];

        default:
            return ["code" => HTTP_METHOD_NOT_ALLOWED, "data" => "La méthode $methode n'est pas supportée."];
    }
}

/**
 * Traiter une requête sur la ressource "cours"
 *
 * @param string $methode
 * @param integer|false|null $id
 * @param array $donnees
 * @return array
 */
function traiterCours(string $methode, int|false|null $id, array $donnees): array
{
    $nomClasse = filter_input(INPUT_GET, "classe", FILTER_SANITIZE_STRING) ?? null;

    switch ($methode) {
        case "GET":
            if ($nomClasse !== null) {
                $horaire = getHoraireParClasse($nomClasse);
                if ($horaire === null) {
                    return ["code" => HTTP_NOT_FOUND, "data" => "Classe introuvable"];
                }
                return ["code" => HTTP_OK, "data" => $horaire];
            }
            if ($id === null) {
                return ["code" => HTTP_OK, "data" => getAllCours()];
            }
            if ($id === false) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id invalide"];
            }
            $cours = getCoursById($id);
            if ($cours === false) {
                return ["code" => HTTP_NOT_FOUND, "data" => "Cours introuvable"];
            }
            return ["code" => HTTP_OK, "data" => $cours];

        case "POST":
            $nouvelId = insertCours($donnees['code'] ?? '', $donnees['nom'] ?? '');
            return ["code" => HTTP_CREATED, "data" => getCoursById($nouvelId)];

        case "PUT":
            if (!$id) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id requis"];
            }
            updateCours($id, $donnees['code'] ?? '', $donnees['nom'] ?? '');
            return ["code" => HTTP_OK, "data" => getCoursById($id)];

        case "DELETE":
            if (!$id) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id requis"];
            }
            deleteCours($id);
            return ["code" => HTTP_NO_CONTENT, "data" => null];

        default:
            return ["code" => HTTP_METHOD_NOT_ALLOWED, "data" => "La méthode $methode n'est pas supportée."];
    }
}

/**
 * Traiter une requête sur la ressource "creneaux"
 *
 * @param string $methode
 * @param integer|false|null $id
 * @param array $donnees
 * @return array
 */
function traiterCreneaux(string $methode, int|false|null $id, array $donnees): array
{
    switch ($methode) {
        case "GET":
            if ($id === null) {
                return ["code" => HTTP_OK, "data" => getAllCreneaux()];
            }
            if ($id === false) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id invalide"];
            }
            $creneau = getCreneauById($id);
            if ($creneau === false) {
                return ["code" => HTTP_NOT_FOUND, "data" => "Créneau introuvable"];
            }
            return ["code" => HTTP_OK, "data" => $creneau];

        case "POST":
            $nouvelId = insertCreneau(
                (int) ($donnees['classe_id'] ?? 0),
                (int) ($donnees['cours_id'] ?? 0),
                $donnees['jour'] ?? '',
                $donnees['heure_debut'] ?? '',
                $donnees['heure_fin'] ?? '',
                $donnees['salle'] ?? ''
            );
            return ["code" => HTTP_CREATED, "data" => getCreneauById($nouvelId)];

        case "PUT":
            if (!$id) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id requis"];
            }
            updateCreneau(
                $id,
                (int) ($donnees['classe_id'] ?? 0),
                (int) ($donnees['cours_id'] ?? 0),
                $donnees['jour'] ?? '',
                $donnees['heure_debut'] ?? '',
                $donnees['heure_fin'] ?? '',
                $donnees['salle'] ?? ''
            );
            return ["code" => HTTP_OK, "data" => getCreneauById($id)];

        case "DELETE":
            if (!$id) {
                return ["code" => HTTP_BAD_REQUEST, "data" => "id requis"];
            }
            deleteCreneau($id);
            return ["code" => HTTP_NO_CONTENT, "data" => null];

        default:
            return ["code" => HTTP_METHOD_NOT_ALLOWED, "data" => "La méthode $methode n'est pas supportée."];
    }
}

?>
