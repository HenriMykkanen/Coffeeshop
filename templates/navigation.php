<nav class="navbar navbar-expand-lg fixed-top customnavbarcolor">
  <div class="container-lg">
    <a class="navbar-brand" href="index.php">
      <img src="https://i.imgur.com/rpukcSB.png" alt="logo" width="50" height="50">
    </a>
    <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-2">
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php">home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            products
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="margin-top: 15px;">
            <li><a class="dropdown-item text-dark" href="catalog.php?category=allproducts">all products</a></li>
            <li><a class="dropdown-item text-dark" href="catalog.php?category=coffeebeans">coffee beans</a></li>
            <li><a class="dropdown-item text-dark" href="catalog.php?category=coffeemachines">coffee machines</a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php
        if ($_SESSION['logged_in'] == false) {
        ?>
          <li class="nav-item">
            <a class="nav-link text-light" href="login.php"><i class="fas fa-sign-in-alt"></i></i> log in</a>
          </li>
        <?php
        } else if ($_SESSION['logged_in'] == true) {
        ?>
          <li class="nav-item">
            <a class="nav-link text-light logoutbutton" href="do_logout.php"><i class="fas fa-sign-out-alt"></i> log out</a>
          </li>
        <?php
        }
        ?>
        <?php if ($_SESSION['logged_in'] == true && $_SESSION['user_role'] == 'admin') {
        ?>
          <li class="nav-item">
            <a class="nav-link text-light" href="productmanagement.php"> product management</a>
          </li>
        <?php
        }
        ?>
        <li class="nav-item">
          <a class="nav-link text-light" href="cart.php">
            <i class="fas fa-cart-plus"></i> cart
            <span id="cart-count">0</span>
        </a>
        </li>
      </ul>
    </div>
  </div>
</nav>