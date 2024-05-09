// Pre fill form when opening the edit modal
$(document).on("click", ".open-editProductModal", function (event) {
  console.log
  var id = $(this).data("id");
  var name = $(this).data("name");
  var description = $(this).data("description");
  var price = $(this).data("price");
  var tax = $(this).data("tax");
  var category_id = $(this).data("category_id");

  // There can be multiple image links so the imagelinks string is split into an array by comma ","
  var imagelinks = $(this).data("imagelinks");
  imagelinks = imagelinks.split(",");

  var imageids = $(this).data("imageids");
  imageids = imageids.split(",");

  let inputHTML = "";

  for (let i = 0; i < imagelinks.length; i++) {
    const imagelinkHTML = /*html*/ `
      <div class="mb-3">
        <label class="form-label" for="imagelink">Imagelink</label>
        <input type="text" name="imagelink[]" class="form-control" id="imagelink${i}">
        <input type="hidden" name="imageID[]" class="form-control" id ="imageids${i}">
      </div>
    `;
    inputHTML += imagelinkHTML;
  }

  let editmodal = document.getElementById("imagelinks");
  editmodal.innerHTML = "";
  editmodal.innerHTML += inputHTML;

  for (let i = 0; i < imagelinks.length; i++) {
    $(`.modal-content #imagelink${i}`).val(imagelinks[i]);
    $(`.modal-content #imageids${i}`).val(imageids[i]);
  }
  $(".modal-content #id").val(id);
  $(".modal-content #name").val(name);
  $(".modal-content #description").val(description);
  $(".modal-content #price").val(price);
  $(".modal-content #tax").val(tax);
  $(".modal-content #category_id").val(category_id);
});

// Pre-fill form when opening the remove modal
$(document).on("click", ".open-removeModal", function (event) {
  var id = $(this).data("id");
  $(".modal-content #id").val(id);
});


function buildTable(productsJSON) {
  const productsAndImages = productsJSON;
  const productsTable = /*html*/ `
  <div>
    <table class="table table-responsive table-bordered table-hover">
      <thead>
        <tr>
          <th>ProductID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Category</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      ${productsAndImages
        .map(
          (product) => /*html*/ ` 
        <tr>
          <td>${product.id}</td>
          <td>${product.name}</td>
          <td>${product.price}</td>
          <td>${product.category_id}</td>
          <td>
            <a 
              href="#editProductModal"
              class="btn btn-outline-primary open-editProductModal"
              data-bs-toggle="modal"
              data-bs-target="#editProductModal"
              data-id="${product.id}"
              data-name="${product.name}"
              data-description="${product.description}"
              data-price="${product.price}"
              data-tax="${product.tax}"
              data-category_id="${product.category_id}"
              data-imagelinks="${product.imagelinks.map((img) => `${img.imagelink}`).join(",")}"
              data-imageids="${product.imagelinks.map((img) => `${img.image_id}`).join(",")}">
              <i class="fas fa-edit"></i> Edit
            </a>
          </td>
          <td>
            <a
            href="#deleteProductModal"
            class="btn btn-outline-danger open-removeModal"
            data-bs-toggle="modal"
            data-bs-target="#deleteProductModal"
            data-id="${product.id}">
            <i class="fas fa-trash"></i> Delete
          </a>
          </td>
        </tr>
      `
        )
        .join("")}
      </tbody>
    </table>
  </div>
  `;
  const targetdiv = document.getElementById("showData");
  targetdiv.innerHTML = "";
  targetdiv.innerHTML = productsTable;
}
// Fetch info of all the products in JSON array format
fetchProductJSON = function () {
  fetch("fetchproductsandimages.php")
    .then(function (response) {
      return response.json();
    })
    .then(function (myJson) {
      const allProducts = myJson;

      buildTable(myJson);
      // Courtesy of https://www.encodedna.com/javascript/populate-json-data-to-html-table-using-javascript.htm
      // Extract value from table header.
      // let headers = [];
      // for (let i = 0; i < allProducts.length; i++) {
      //   for (let key in allProducts[i]) {
      //     if (headers.indexOf(key) === -1) {
      //       headers.push(key);
      //     }
      //   }
      // }

      // // Create table.
      // const table = document.createElement("table");
      // table.setAttribute(
      //   "class",
      //   "table table-hover table-responsive text-center"
      // );

      // // Create table header row using the extracted headers above.
      // let tr = table.insertRow(-1); // table row.

      // for (let i = 0; i < headers.length; i++) {
      //   let th = document.createElement("th"); // table header.
      //   th.innerHTML = headers[i];
      //   tr.appendChild(th);
      // }

      // for (let i = 0; i < 2; i++) {
      //   let emptyheader = document.createElement("th"); // empty table header for buttons
      //   emptyheader.innerHTML = "";
      //   tr.appendChild(emptyheader);
      // }

      // // add json data to the table as rows.
      // for (let i = 0; i < allProducts.length; i++) {
      //   tr = table.insertRow(-1);

      //   for (let j = 0; j < headers.length; j++) {
      //     let tabCell = tr.insertCell(-1);
      //     tabCell.innerHTML = allProducts[i][headers[j]];
      //   }

      //   // EDIT BUTTON
      //   // Create edit button cell
      //   let editButtonCell = tr.insertCell(-1);
      //   editButtonCell.innerHTML = "";

      //   // Create edit button and bind data from JSON array
      //   let editButton = document.createElement("a");
      //   editButton.setAttribute("onClick", "fetchProductJSON()");
      //   editButton.setAttribute(
      //     "class",
      //     "btn btn-outline-primary open-editProductModal"
      //   );
      //   editButton.setAttribute("href", "#editProductModal");
      //   editButton.setAttribute("data-bs-toggle", "modal");
      //   editButton.setAttribute("data-bs-target", "#editProductModal");
      //   editButton.setAttribute("data-id", allProducts[i][headers[0]]);
      //   editButton.setAttribute("data-name", allProducts[i][headers[1]]);
      //   editButton.setAttribute("data-description", allProducts[i][headers[2]]);
      //   editButton.setAttribute("data-price", allProducts[i][headers[3]]);
      //   editButton.setAttribute("data-tax", allProducts[i][headers[4]]);
      //   editButton.setAttribute("data-category", allProducts[i][headers[5]]);

      //   // Create edit button icon
      //   let editButtonIcon = document.createElement("i");
      //   editButtonIcon.setAttribute("class", "fas fa-edit");
      //   editButton.appendChild(editButtonIcon);

      //   // Create edit button text
      //   editButton.appendChild(document.createTextNode(" Edit"));
      //   editButtonCell.appendChild(editButton);

      //   // DELETE BUTTON
      //   // Create delete button cell
      //   let deleteButtonCell = tr.insertCell(-1);
      //   deleteButtonCell.innerHTML = "";

      //   // Create delete button and bind data from JSON array
      //   let deleteButton = document.createElement("a");
      //   deleteButton.setAttribute("onClick", "fetchProductJSON()");
      //   deleteButton.setAttribute(
      //     "class",
      //     "btn btn-outline-danger open-removeModal"
      //   );
      //   deleteButton.setAttribute("href", "#deleteProductModal");
      //   deleteButton.setAttribute("data-bs-toggle", "modal");
      //   deleteButton.setAttribute("data-bs-target", "#deleteProductModal");
      //   deleteButton.setAttribute("data-id", allProducts[i][headers[0]]);

      //   // Create delete button icon
      //   let deleteButtonIcon = document.createElement("i");
      //   deleteButtonIcon.setAttribute("class", "fas fa-trash");
      //   deleteButton.appendChild(deleteButtonIcon);

      //   // Create delete button text
      //   deleteButton.appendChild(document.createTextNode(" Delete"));
      //   deleteButtonCell.appendChild(deleteButton);
      // }

      // // Now, add the newly created table with json data, to a container.
      // const divShowData = document.getElementById("showData");
      // divShowData.innerHTML = "";
      // divShowData.appendChild(table);
    });
};

// Courtesy of https://www.digitalocean.com/community/tutorials/submitting-ajax-forms-with-jquery
// Ajax call when add product form is submitted
$(document).ready(function () {
  $("#add_product_form").submit(function (event) {
    var formData = $("#add_product_form").serialize();
    $.ajax({
      type: "POST",
      url: "/henri_mykkanen/näyttötyö/ajax/ajax.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      $("#addProductModal").modal("hide");
      fetchProductJSON();
    });
    event.preventDefault();
  });
});

// Ajax call when edit product form is submitted
$(document).ready(function () {
  $("#edit_product_form").submit(function (event) {
    var formData = $("#edit_product_form").serialize();
    $.ajax({
      type: "POST",
      url: "/henri_mykkanen/näyttötyö/ajax/ajax.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      $("#editProductModal").modal("hide");
      fetchProductJSON();
    });
    event.preventDefault();
  });
});

// Ajax call when delete product form is submitted
$(document).ready(function () {
  $("#delete_product_form").submit(function (event) {
    var formData = {
      id: $("#id").val(),
      formtype: "deleteproduct",
    };

    $.ajax({
      type: "POST",
      url: "/henri_mykkanen/näyttötyö/ajax/ajax.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      $("#deleteProductModal").modal("hide");
      fetchProductJSON();
    });
    event.preventDefault();
  });
});

// Create a new form element for image links
function addNewImageLinkInput() {
  let targetdiv = document.getElementById("addProductModalBody");

  const div = document.createElement("div");
  div.setAttribute("class", "form-group");

  const input = document.createElement("input");
  input.setAttribute("type", "text");
  input.setAttribute("class", "form-control");
  input.setAttribute("placeholder", "https://i.imgur.com/8oZZEIJ.png");
  input.setAttribute("name", "imagelink[]");

  div.appendChild(input);

  targetdiv.appendChild(div);
}

fetchCartItemCount = function () {
  fetch("fetchCartItemCount.php")
  .then(function (response) {
    return response.json();
  })
  .then(function (myJson) {
    updateCartCount(myJson);
  });
}

function updateCartCount(cartItemCount) {

    const cartCountElement = document.getElementById("cart-count");
    cartCountElement.textContent = cartItemCount;
    if (cartItemCount > 0) {
      cartCountElement.classList.add("more");
    } else {
      cartCountElement.classList.remove("more");
    }
}

window.addEventListener("load", fetchCartItemCount);

