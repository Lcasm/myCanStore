<?php
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

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>The Can Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Cherry+Swash|Raleway" rel="stylesheet">
  <link href="can-style.css" rel="stylesheet">
  <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
  <header>
    <h1><a href="index.html">Au jardin en boite</a></h1>
  </header>
  <div>
    <aside>
      <form method="post" id="formSelect">
        <div>
          <label for="category">Choix de catégorie:</label>
          <select id="category" name="category">
            <option selected>Tous</option>
            <option>Legumes</option>
            <option>Viande</option>
            <option>Soupe</option>
          </select>
        </div>
        <div>
          <label for="nutriscore">Nutriscore:</label>
          <select id="nutriscore" name="nutriscore">
            <option selected>Tous</option>
            <option>A</option>
            <option>B</option>
            <option>C</option>
            <option>D</option>
            <option>E</option>
          </select>
        </div>
        <div>
          <label for="searchTerm" >Entre le terme de recherche:</label>
          <input type="text" id="searchTerm" name="searchTerm" placeholder="ex : Petits pois">
        </div>
        <div>
          <button name="envoyer">afficher le resultat</button>
        </div>
      </form>
    </aside>
    <main>
      <?php 
      $selectNutri = '';
      $selectType = '';
      $searchTerm = '';
      if (isset($_POST['envoyer'])){
        $selectNutri = $_POST['nutriscore'];
        $selectType = $_POST['category'];
        $searchTerm = $_POST['searchTerm'];
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
    </main>
  </div>
  <footer>
    <p><a href="http://localhost/Ajax/Exemple04/index.html">TP BOUTIQUE (AJAX – JSON)</a>

      A partir des fichiers fournis, vous êtes chargé de :<br>
    <ol>
      <li>Franciser les commentaires du code JS pour une meilleure compréhension et la page html pour le public
        français. La boutique s’appellera : "Au jardin en boite".</li>
      <li> La méthode d’accès aux images est : function fetchBlob(product). Supprimer cette fonction en utilisant
        simplement l’url de l’image transmise par le JSON pour paramétrer l’attribut « src » des images dans la function
        showProduct(objectURL, product) qui ne prendra donc plus qu’un argument « product ».</li>
      <li> Adapter le script pour faire fonctionner la page de présentation des produits avec le fichier JSON joint : «
        produits.json ». La loi oblige le vendeur à afficher le « nutri-score » du produit. Mettre en œuvre cet ajout.
      </li>
      <li>Le client souhaite un nouveau look plus moderne, nature et une page responsive…</li>
    </ol>
    </p>
  </footer>
  <!--<script src="can-script.js"></script>-->
</body>

</html>