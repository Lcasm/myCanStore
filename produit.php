<?php
$selectNutri = '';
$selectType = '';
$searchTerm = '';
if (isset($_POST['envoyer']) or isset($_GET['first'])){
  if (isset($_POST['envoyer'])){
    $selectNutri = $_POST['nutriscore'];
    $searchTerm = $_POST['searchTerm'];
    $selectType = $_POST['category'];
  }else{
    $selectType = $_GET['first'];
  }
}
if ($selectNutri == 'Tous'){
  $selectNutri = '';
}
if ($selectType == 'Tous'){
  $selectType = '';
}

$where = 'select * from produits where nutriscore like "%'.$selectNutri.'%" and type like "%'.$selectType.'%" and nom like "%'.$searchTerm.'%"';

//sqlrequest
$select = $connection -> query($where);
$select->setFetchMode(PDO::FETCH_OBJ);
// affichage des produit
while($enregistrement = $select->fetch())
{
echo '
      <section class="'.$enregistrement->type.'">
        <h2>'.$enregistrement->nom.'</h2>
        <p>'.$enregistrement->prix.'€</p>
        <img src="images/'.$enregistrement->image.'" alt="'.strtolower($enregistrement->nom).'">
        <h3>
          Nutriscore :
          <span class="'.$enregistrement->nutriscore.'">'.$enregistrement->nutriscore.'</span>
        </h3>
      </section>
     ';
}
?>