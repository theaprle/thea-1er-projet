<?php

// Lecture des paramétres de connexion à la base dedonnée
try{
    $env = parse_ini_file('../.env');
}catch (exception $e) {
    die("Vous devez créer un `.env` à la racine");
}


try {
    $host = $env['host'];
    $base = $env['database'];
    $bdd = new PDO("mysql:host=$host;dbname=$base", $env['user'], $env['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br/>";
    die();
 }
