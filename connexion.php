<?php
//connexion a la bdd
try {
  $dns = 'mysql:host=localhost;dbname=canStore'; // dbname : nom de la base
  $utilisateur = 'root'; // root sur vos postes
  $motDePasse = ''; // pas de mot de passe sur vos postes
  $connection = new PDO( $dns, $utilisateur, $motDePasse );
  $connection->exec('SET NAMES utf8');
} catch (Exception $e) {
    echo "Connexion à MySQL impossible : ", $e->getMessage();
    die();
}
?>