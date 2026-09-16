# Gestion Horaire

Application web (PHP + MySQL) avec API RESTful permettant de gérer les horaires des classes du CFPT (classes, cours, créneaux).

## Auteur

Korbi Yassine

## Créer la base de données et importer le SQL

1. Démarrer Apache et MySQL dans XAMPP.
2. Ouvrir phpMyAdmin : http://localhost/phpmyadmin
3. Aller dans l'onglet **Importer**.
4. Choisir le fichier `sql/init.sql` de ce projet.
5. Cliquer sur **Exécuter**.

Cela crée automatiquement la base `GestionHoraire`, les tables `classes`, `cours`, `creneaux`, ainsi que quelques données d'exemple.

6. Vérifier les identifiants MySQL dans `config/config.php` (`DB_USER`, `DB_PASS`) et les adapter si besoin à votre installation.

## Lancer le projet

Placer le dossier dans `C:\xampp\htdocs\` puis ouvrir dans le navigateur :

```
http://localhost/GestionHoraire/
```

## Pages du site

- `/index.php` : accueil
- `/pages/classes.php` : ajouter / lister / supprimer les classes
- `/pages/cours.php` : ajouter / lister / supprimer les cours
- `/pages/horaire.php` : ajouter / consulter / supprimer les créneaux d'horaire

## URL des API

Toutes les routes passent par `api/index.php` avec le paramètre `resource`.

| Méthode | URL | Description |
|---|---|---|
| GET | `/api/index.php?resource=classes` | Liste des classes |
| GET | `/api/index.php?resource=classes&id=1` | Une classe |
| POST | `/api/index.php?resource=classes` | Ajouter une classe (JSON : `nom`, `annee_scolaire`) |
| PUT | `/api/index.php?resource=classes&id=1` | Modifier une classe |
| DELETE | `/api/index.php?resource=classes&id=1` | Supprimer une classe |
| GET | `/api/index.php?resource=cours` | Liste des cours |
| GET | `/api/index.php?resource=cours&id=1` | Un cours |
| GET | `/api/index.php?resource=cours&classe=I.DA-P3A` | Horaire complet de la classe I.DA-P3A |
| POST | `/api/index.php?resource=cours` | Ajouter un cours (JSON : `code`, `nom`) |
| PUT | `/api/index.php?resource=cours&id=1` | Modifier un cours |
| DELETE | `/api/index.php?resource=cours&id=1` | Supprimer un cours |
| GET | `/api/index.php?resource=creneaux` | Liste des créneaux |
| GET | `/api/index.php?resource=creneaux&id=1` | Un créneau |
| POST | `/api/index.php?resource=creneaux` | Ajouter un créneau (JSON : `classe_id`, `cours_id`, `jour`, `heure_debut`, `heure_fin`, `salle`) |
| PUT | `/api/index.php?resource=creneaux&id=1` | Modifier un créneau |
| DELETE | `/api/index.php?resource=creneaux&id=1` | Supprimer un créneau |

Exemple : `GET http://localhost/GestionHoraire/api/index.php?resource=cours&classe=I.DA-P3A`

```json
{
    "classe": "I.DA-P3A",
    "annee_scolaire": "2026-2027",
    "horaires": [
        {
            "jour": "jeudi",
            "heure_debut": "08:05",
            "heure_fin": "11:40",
            "cours": "Atelier Web 3e année S1",
            "code_cours": "AWEB3",
            "salle": "R104"
        }
    ]
}
```
