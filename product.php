<?php
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');

$productID = $_GET['productid'];
?>

<body onload="fetchProductAndImagesJSON()">
    <section class="maincontent">
        <div class="container">
            <div class="card rounded productpagecard">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-6">
                            <div class="card-title text-center">
                                <h3 id="productname"></h3>
                            </div>
                            <div class="white-box text-center">
                                <img id="mainimage" class="img-fluid rounded" src="" alt="productimage" title="" style="">
                            </div>
                            <div class="small-images">
                                <img id="smallimage1" class="small-image active pl-2" src="" alt="productimage" title="">
                                <img id="smallimage2" class="small-image pl-2" src="" alt="productimage" title="">
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-6 d-flex justify-content-center flex-column">
                            <h5 class="box-title mt-5">Description:</h5>
                            <div>
                                <p class="fs-6 text-start" id="productdescription"></p>
                                <p class="mt-5 fs-3 fw-bolder text-center" id="productprice"></p>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button class="btn custombutton-darktext btn-rounded" id="addtocartbutton" data-bs-toggle="tooltip" title="" data-original-title="Add to cart">
                                            <i class="fa fa-shopping-cart"></i> Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
    <?php require('templates/footer.php'); ?>
    <script>
        fetchProductAndImagesJSON = function() {
            fetch('fetchproductandimages.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: <?php echo $productID ?>
                })
            }).then(function(response) {
                return response.json();
            }).then(function(productInfo) {

                document.getElementById('productname').innerHTML = productInfo[0].name;

                let productimage = document.getElementById('mainimage');
                productimage.setAttribute('src', productInfo[0].imagelink);
                productimage.setAttribute('alt', 'productimage');

                let smallimage1 = document.getElementById('smallimage1');
                smallimage1.setAttribute('src', productInfo[0].imagelink);

                let smallimage2 = document.getElementById('smallimage2');
                smallimage2.setAttribute('src', productInfo[1].imagelink);

                document.getElementById('productdescription').innerHTML = productInfo[0].description;

                document.getElementById('productprice').innerHTML = productInfo[0].price + '€';

                let addToCartButton = document.getElementById('addtocartbutton');
                addToCartButton.setAttribute('data-id', productInfo[0].id);
            })
        }

        $(document).ready(function() {
            $("#addtocartbutton").on("click", function(e) {
                e.preventDefault();
                var productID = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "/henri_mykkanen/näyttötyö/ajax/addProductToCart.php",
                    data: {
                        id: productID,
                        requestType: 'addProductToCart'
                    },
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    fetchCartItemCount();
                });
            });
        });

        $(document).ready(function() {
            $('.small-image').click(function() {
                var newSrc = $(this).attr('src');
                $('#mainimage').attr('src', newSrc);
                $('.small-image').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
</body>