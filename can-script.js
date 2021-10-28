// var qui va contenir les produit
var products;
var myForm = document.getElementById('formSelect');
formdata = new FormData(myForm);

for (var x of formdata) console.log(x);
// ajout du fichier json dans la var product 
// fetch pour eviter les erreur
fetch('index.php',{method:"post",body:formdata}).then(function (response) {
  if (response.ok) {
    response.json().then(function (json) {
      products = json;
      initialize();
    });
  } else {
    console.log('Network request for products.json failed with response ' + response.status + ': ' + response.statusText);
  }
});

// fonction principal
function initialize() {
  // mise en var des element modifiable(filtre) du site
  var category = document.querySelector('#category');
  var nutriscore = document.querySelector('#nutriscore');
  var searchTerm = document.querySelector('#searchTerm');
  var searchBtn = document.querySelector('button');
  var main = document.querySelector('main');

  var lastCategory = category.value;
  var lastnutriscore = nutriscore.value;
  var lastSearch = '';
  var categoryGroup = [];
  var finalGroup = [];
  finalGroup = products;

  updateDisplay();

  //au click du bonton afficher 
  searchBtn.onclick = selectCategory; 
  //ont met dans categoryGroup les element dans les condition des filtre
  function selectCategory(e) {

    
    e.preventDefault();
    //categoryGroup = [];
    finalGroup = [];

      lastnutriscore = nutriscore.value
      lastCategory = category.value;
      lastSearch = searchTerm.value.trim();
      //var myForm = document.getElementById('formSelect');
      formdata = new FormData(myForm);
      //for (var x of formdata) console.log(x);
      fetch('index.php',{method:"post",body:formdata}).then(function (response){//'produits.php?nutriscore='+lastnutriscore+'&category='+lastCategory+'&searchTerm='+lastSearch).then(function (response) {
        if (response.ok) {
          response.json().then(function (json) {
            finalGroup = json;
            updateDisplay();
          });
        } else {
          console.log('Network request for products.json failed with response ' + response.status + ': ' + response.statusText);
        }
      });
        
  }


  // vide les produit afficher puis envois des nouveau elements vers showProduct
  function updateDisplay() {
    while (main.firstChild) {
      main.removeChild(main.firstChild);
    }

    if (finalGroup.length === 0) {
      var para = document.createElement('p');
      para.textContent = 'No results to display!';
      main.appendChild(para);
    } else {
      fisherYatesShuffle(finalGroup)
      for (var i = 0; i < finalGroup.length; i++) {
        showProduct(finalGroup[i]);
      }
    }
  }

  // function melange de tableau
  function fisherYatesShuffle(arr){
    for(var i =arr.length-1 ; i>0 ;i--){
        var j = Math.floor( Math.random() * (i + 1) );
        [arr[i],arr[j]]=[arr[j],arr[i]];
    }
  }

  //function pour ajouter les produit dans le html
  function showProduct(product) {
    //creation des element composant le produit
    var url = 'images/' + product.image;
    var section = document.createElement('section');
    var heading = document.createElement('h2');
    var para = document.createElement('p');
    var image = document.createElement('img');
    var txtnutriscore = document.createElement('h3')
    var nutriscore = document.createElement('span')
    
    section.setAttribute('class', product.type);

    heading.textContent = product.nom.replace(product.nom.charAt(0), product.nom.charAt(0).toUpperCase());

    para.textContent = parseFloat(product.prix).toFixed(2) + '€';

    image.src = url;
    image.alt = product.nom;

    //mis en couleur selon le nutriscore
    nutriscore.textContent = product.nutriscore
    if (nutriscore.textContent == 'A'){nutriscore.classList.add("A")}
    else if (nutriscore.textContent == 'B'){nutriscore.classList.add("B")}
    else if (nutriscore.textContent == 'C'){nutriscore.classList.add("C")}
    else if (nutriscore.textContent == 'D'){nutriscore.classList.add("D")}
    else if (nutriscore.textContent == 'E'){nutriscore.classList.add("E")}
     
    txtnutriscore.textContent = 'Nutriscore : '

    // on ajoute les element du produit dans le html
    main.appendChild(section);
    section.appendChild(heading);
    section.appendChild(para);
    section.appendChild(image);
    section.appendChild(txtnutriscore)
    txtnutriscore.appendChild(nutriscore)
  }
}
