
<?php
// arg $connect = connexion a la bdd
function requeteCat(){
    global $connection;
    $selectCategory = $connection -> query('select DISTINCT type from produits order by type');
    $selectCategory->setFetchMode(PDO::FETCH_OBJ);
    while($enregistrement = $selectCategory->fetch())
    {
    ?>
    <option <?php {if (isset($_POST['category'])){if($_POST['category'] == $enregistrement->type){echo 'selected';}}} ?>><?php echo $enregistrement->type ?> </option>
    <?php
    //retourne les category presente dans la bdd
    }
}
// arg $connect = connexion a la bdd
function requeteNutri(){
    global $connection;
    $selectNutriscore = $connection -> query('select DISTINCT nutriscore from produits order by nutriscore');
    $selectNutriscore->setFetchMode(PDO::FETCH_OBJ);
    while($enregistrement = $selectNutriscore->fetch())
    {
    ?>
      <option <?php {if (isset($_POST['category'])){if($_POST['nutriscore'] == $enregistrement->nutriscore){echo 'selected';}}} ?>><?php echo $enregistrement->nutriscore ?> </option>
  <?php
    //retourne les nutriscore presente dans la bdd
    }
}
?>