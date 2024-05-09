<?php
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.base.php');
require('lib/class.product.php');

?>

<body onload="fetchProductJSON()">
    <section class="maincontent">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Product management</h3>
                    <div class="row justify-content-center" style="padding-bottom:20vh">
                        <div class="col-lg-12 col-xs-10">
                            <button type="button" class="btn btn-outline-primary" style="margin-bottom: 5px;" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="fas fa-file-upload"></i> Add product</button>
                            <div class="table-responsive" id="showData">
                                <!-- Products table will be built here with JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Add product modal -->
            <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="näyttötyö/ajax/ajax.php" method="POST" id="add_product_form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProductModalLabel">Add product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="addProductModalBody">
                                <div id="name-group" class="mb-3">
                                    <label for="newproductname" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="newproductname" name="name" placeholder="Name">
                                </div>
                                <div class="mb-3">
                                    <label for="newproductdescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="newproductdescription" name="description" placeholder="Description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="newproductprice" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="newproductprice" name="price" placeholder="Price">
                                </div>
                                <div class="mb-3">
                                    <label for="newproducttax" class="form-label">Tax</label>
                                    <input type="text" class="form-control" id="newproducttax" name="tax" placeholder="Tax">
                                </div>
                                <div class="mb-3">
                                    <label for="newproductcategory" class="form-label">Category</label>
                                    <p class="fs-6">1 = Coffee Beans - 2 = Coffee Machine</p>
                                    <input type="text" class="form-control" id="newproductcategory" name="category" placeholder="Category">
                                    <input type="hidden" name="formtype" value="addproduct">
                                </div>
                                <div class="mb-3">
                                    <label for="newproductimagelink" class="form-label">Image link or links</label>
                                    <input type="text" class="form-control" name="imagelink[]" placeholder="https://i.imgur.com/8oZZEIJ.png">
                                </div>
                            </div>
                            <div style="padding-left: 16px; padding-bottom: 16px; padding-right: 16px;">
                                <button type="button" class="btn btn-outline-success" onclick="addNewImageLinkInput()"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i>Add new product</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit product modal -->
            <div id="editProductModal" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="näyttötyö/ajax/ajax.php" method="POST" id="edit_product_form">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="edit-modal-body">
                                <div class="mb-3">
                                    <label class="form-label" for="id">ProductID</label>
                                    <input type="text" class="form-control" id="id" name="id" value="" readonly />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="tax">Tax</label>
                                    <input type="text" class="form-control" id="tax" name="tax" placeholder="Tax">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="category">Category</label>
                                    <p class="fs-6">1 = Coffee Beans - 2 = Coffee Machine</p>
                                    <input type="text" class="form-control" id="category_id" name="category_id" placeholder="Category">
                                    <input type="hidden" name="formtype" value="editproduct">
                                </div>
                                <div id="imagelinks">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    Edit product</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete product modal -->
            <div id="deleteProductModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title">Delete product</div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="näyttötyö/ajax/ajax.php" method="POST" id="delete_product_form">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="inlineFormInputName">ProductID to be deleted</label>
                                    <input type="text" class="form-control" id="id" name="id" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    Delete product</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    <?php require('templates/footer.php'); ?>
</body>