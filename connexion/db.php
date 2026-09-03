<?php

require_once "../config/config.php";

/**
 * Fonction qui accède à la base de données (PDO)
 *  
 * @return PDO
 */
function db() : PDO
{
    static $pdo = null;
    if ( $pdo === null ) {
        $dsn = "mysql:host=". DB_HOST .";dbname=". DB_NAME .";charset=utf8";
        $pdo = new PDO( $dsn, DB_USER, DB_PASS );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    return $pdo;
}

/**
 * Fonction qui prépare et éxecute une requête SQL
 *
 * @param string $sql
 * @param array|null|null $param
 * @return PDOStatement
 */
function dbRun(string $sql, array|null $param = null) : PDOStatement
{
    $statement = db()->prepare($sql);
    $statement->execute($param);
    return $statement;
}

?>