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
$selectNutri = $_GET['nutriscore'];
$selectType = $_GET['category'];
$searchTerm = $_GET['searchTerm'];

if ($selectNutri == 'Tous'){
  $selectNutri = '';
}
if ($selectType == 'Tous'){
  $selectType = '';
}

$where = ' where nutriscore like "%'.$selectNutri.'%" and type like "%'.$selectType.'%" and nom like "%'.$searchTerm.'%"';



/*if ($selectNutri != 'Tous'){
  $where = " where ".$where.'nutriscore="'.$selectNutri.'"';
  if($selectType != 'Tous'){
    $where = $where." and ";
  }
}

if($selectType != 'Tous'){
  if ($selectNutri == 'Tous'){
    $where = " where ";
  }
  $where = $where.'type="'.$selectType.'"';
}

if($searchTerm != ''){
  if($selectNutri == 'Tous' && $selectType == 'Tous'){
    $where = ' where nom like "%'.$searchTerm.'%"';
  }
  else{
    $where = $where.' and nom like "%'.$searchTerm.'%"';
  }
}*/

//sqlrequest
$select = $connection -> query("select * from produits".$where);
$select->setFetchMode(PDO::FETCH_OBJ);

//afficher la sqlrequest
$strProduit = '[';
while($enregistrement = $select->fetch())
{
  $strProduit = $strProduit.'{ 
                    "nom":"'.$enregistrement->nom.'",
                    "prix":'.strval($enregistrement->prix).',
                    "image":"'.$enregistrement->image.'",
                    "type":"'.$enregistrement->type.'",
                    "nutriscore":"'.strval($enregistrement->nutriscore).'"
                  },';
  
}
$strProduit = substr($strProduit, 0, -1);
echo $strProduit.']';
?>