<?php 
header("Content-type: application/json; charset-utf-8");

//sql connection
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

//sql condition filtre
$selectNutri = $_POST['nutriscore'];
$selectType = $_POST['category'];
$searchTerm = $_POST['searchTerm'];

if ($selectNutri == 'Tous'){
  $selectNutri = '';
}
if ($selectType == 'Tous'){
  $selectType = '';
}

$where = 'select * from produits where nutriscore like "%'.$selectNutri.'%" and type like "%'.$selectType.'%" and nom like "%'.$searchTerm.'%"';

//sqlrequest
$select = $connection -> query($where);
$produits = json_encode($select->fetchAll( PDO::FETCH_ASSOC ));
// affichage du Json
echo ($produits);
?>