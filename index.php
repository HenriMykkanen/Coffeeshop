<?php
require('templates/header.php');
require('templates/navigation.php');
session_start();
?>

<body onload="fetchProductsAndImages()">
  <section class="maincontent">
    <div class="container">
      <div class="card rounded">
        <img class="card-img-top img-fluid " src="https://img.freepik.com/free-photo/coffee-beans-dark-background-top-view-coffee-concept-banner_1220-6300.jpg?w=1380&t=st=1680021166~exp=1680021766~hmac=65ccd04a370a9e47a085bfed625184b267070eb4a7cbfa6203e660846423be1f" alt="alt text">
        <div class="card-img-overlay">
          <div class="position-absolute top-50 start-50 translate-middle">
            <a href="catalog.php" class="btn custombutton fw-bolder">
              Start shopping
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="card rounded" style="background-color: #8e7970;">
        <div class="card-body">
          <!-- <p class="fs-4">Subscribe to our newsletter</p>
          <p class="fs-6">Stay up to date with our latest offers and products by subscribing to our newsletter.</p> -->
          <form>
          <div class="form-group row text-center d-flex align-items-center">
            <div class="col-sm-5">
            <p class="fs-4 mb-0 text-light">Subscribe to our newsletter</p>
            </div>
            <div class="col-sm-5">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email">
            </div>
            <div class="col-sm-2">
              <button type="submit" class="btn custombutton ">Subscribe</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card rounded">
        <div class="card-body">
          <div class="text-center">
            <h3>Featured products:</h3>
            <div id="displaysuggestions"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php require('templates/footer.php'); ?>
  <script>
    fetchProductsAndImages = function() {
      fetch('fetchproductsandimages.php').then(function(response) {
        return response.json();
      }).then(function(myJson) {
        suggestProducts(myJson);
      })
    }

    // Generates a html template containing 4 random product suggestions
    function suggestProducts(productsJSON) {

      const allProducts = productsJSON;
      const randomProducts = [];

      // Uses math random to pick 4 random products from all of the products
      while (randomProducts.length < 4) {
        const randomIndex = Math.floor(Math.random() * allProducts.length);
        const randomProduct = allProducts[randomIndex];

        if (!randomProducts.includes(randomProduct)) {
          randomProducts.push(randomProduct);
        }
      }

      const suggestionsTemplate = /*html*/
        `
    <p class="fs-6">Here are some suggestions to satisfy your coffee needs:</p>
    <div class="row">
    ${randomProducts.map(product => /*html*/ `
    <div class="col-lg-3 col-md-6 d-flex align-items-stretch text-center">
        <div class="card rounded mb-4 box-shadow">
            <img class="card-img-top" src="${product.imagelinks[0].imagelink}" alt="${product.name}">
            
            <div class="card-body d-flex flex-column justify-content-between">
                <p class="card-title fs-6">${product.name}</p>
                <p class="card-text fs-6 fw-bold mb-0">${product.price}€</p>
                <div class="">
                    <div class="btn-group">
                        <a href="product.php?productid=${product.id}" class="btn btn-sm custombutton-darktext">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `).join('')}
    </div>
    `;
      let targetdiv = document.getElementById('displaysuggestions');
      targetdiv.innerHTML = suggestionsTemplate;

    }
  </script>
</body>