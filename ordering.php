<!DOCTYPE html>
  <html lang="en">
    
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styles/ordering.css" />
      <title>Ordering</title>
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet"
      />
      <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
      />
    </head>

    <body>
      <div class="layout" id="page">
        <div class="left-container">
          <!-- left-container above -->
          <div class="welcome-container">
            <div class="welcome">
              <!-- Home-button -->
              <div class="button-logo">
                <div class="back-button">
                  <a href="index.php"><img src="./images/back.png" /></a>
                </div>
                <!-- logo -->
                <div class="img-logo">
                  <img src="./images/wheel-logo.png" alt="" />
                </div>
              </div>
              <!-- Button order list! -->
              <div class="order-button-container">
                <nav>
                  <ul class="navbar">
                  <li><a href="#silog-nav">SILOG MEAL</a></li>
                  <li><a href="#snacks-nav">SNACKS</a></li>
                  <li><a href="#beverages-nav">HOT BEVERAGES</a></li>
                  <li><a href="#milktea-nav">MILKTEA</a></li>
                  <li><a href="#fruit-nav">FRUIT TEA</a></li>
                  <li><a href="#frappucino-nav">FRAPPUCINO</a></li>
                  <li><a href="#mango-nav">MANGO OVERLOAD</a></li>
                  <li><a href="#icecoffee-nav">ICE COFFEE LATTE</a></li>
                  <li><a href="#milkshake-nav">MILKSHAKE SERIES</a></li>
                  <li><a href="#creamy-nav">CREAMY CLASSIC FRAPPE</a></li>
                  <li><a href="#icecold-nav">ICE COLD BREW AMERICANO</a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- Left-container below -->
          <div class="order-list-container">
        <div class="order-overflow">
          <!-- SILOG MEAL -->
          <h2 class="order-title" id="silog-nav">SILOG MEAL</h2>
          <div class="order-list-grid js-orders-grid" id="silog"></div>

          <!-- SNACKS -->
          <h2 class="order-title" id="snacks-nav">SNACKS</h2>
          <div class="order-list-grid js-orders-grid-1" id="snacks"></div>

          <!-- Hot Beverages -->
          <h2 class="order-title" id="beverages-nav">Hot Beverages</h2>
          <div class="order-list-grid js-orders-grid-2" id="beverages"></div>

          <!-- Milktea -->
          <h2 class="order-title" id="milktea-nav">Milktea</h2>
          <div class="order-list-grid js-orders-grid-3" id="milktea"></div>

          <!-- Fruit Tea -->
          <h2 class="order-title" id="fruit-nav">Fruit Tea</h2>
          <div class="order-list-grid js-orders-grid-4" id="fruit"></div>

          <!-- Frappuccino -->
          <h2 class="order-title" id="frappucino-nav">Frappuccino</h2>
          <div class="order-list-grid js-orders-grid-5" id="frappucino"></div>

          <!-- Mango Overload -->
          <h2 class="order-title" id="mango-nav">Mango Overload</h2>
          <div class="order-list-grid js-orders-grid-6" id="mango"></div>

          <!-- Ice Coffee Latte -->
          <h2 class="order-title" id="icecoffee-nav">Ice Coffee Latte</h2>
          <div class="order-list-grid js-orders-grid-7" id="latte"></div>

          <!-- Milkshake Series -->
          <h2 class="order-title" id="milkshake-nav">Milkshake Series</h2>
          <div class="order-list-grid js-orders-grid-8" id="milkshake"></div>

          <!-- Creamy Classic Frappe -->
          <h2 class="order-title" id="creamy-nav">Creamy Classic Frappe</h2>
          <div class="order-list-grid js-orders-grid-9" id="creamy"></div>

          <!-- Ice Cold Brew Americano -->
          <h2 class="order-title" id="icecold-nav">Ice Cold Brew Americano</h2>
          <div class="order-list-grid js-orders-grid-10" id="americano"></div>
        </div>
      </div>
        </div>

        <!-- CART CONTAINER -->
        <div class="right-container">
          <div class="right-text">
            <h2>My <br />order</h2>
            <h3 id="selectedOption">Dine in</h3>
          </div>

          <!-- grid-my-order-list-container -->
          <div class="my-order-list-container">
            <div class="my-order-list">
              
            </div>
          </div>

          <!-- grid-my-order-total -->
          <div class="my-order-total-container">
            <div class="my-order-total-submit">
              <hr class="line" />
              <h2 class="totalAmount">₱ 0.00</h2>
              <h3>Total: </h3>
              <button id="done-button"class="submit-order">Done</button>
            </div>
          </div>
        </div>

      <!-- <div class="queue-number">
        <button id="cash"><img src="./images/cash.png"></button>
        <button id="gcash"><img src="./images/gcash.png"></button>
      </div> -->

      <div class="js-orders-grid"></div>
      <div class="js-orders-grid-1"></div>
      <!-- Other grid containers for different product categories -->

      <div class="popup-box" id="myPopup">
        <span class="close" id="closePopup">&times;</span>
        <div class="popup-content"></div>
        <div class="quantity-control">
          <button class="decrease">-</button>
          <input type="number" id="quantity" value="1" min="1" />
          <button class="increase">+</button>
        </div>
        <!-- Price placeholder -->
   

        <!-- CONTENTS FOR POPUP-BOX -->
        <div class="size-order" id="size-order" style="display: none">
          <input type="radio" id="medium" name="size" value="Medium" checked>
          <label for="medium" class="size-label">Medium</label>
          <input type="radio" id="large" name="size" value="Large">
          <label for="large" class="size-label">Large</label>
        </div>
        <div id="calculator" style="display: none">
          <label for="sugarPercentage">Sugar Percentage:</label>
          <select id="sugarPercentage">
            <option value="25%">25%</option>
            <option value="50%" >50%</option>
            <option value="75%" selected>75%</option>
            <option value="100%">100%</option>
          </select>
        </div>
        
        <div class="popup-box-total">
          <button id="addToCartBtn">Add</button>
        </div>
      </div>

      <div class="popup-cart" id="myPopupCart">
      <span class="close1" id="closePopup1">&times;</span>
        <div class="popup-cart-img"><img src="./images/choco.png"></div>
        <div class="popup-cart-name">choco</div>
        <div class="popup-cart-quantity">
          <div class="quantity-control">
            <button class="decrease">-</button>
            <input type="number" id="quantity-cart" value="1" min="1" />
            <button class="increase">+</button>
          </div>
        </div>
        <div class="popup-cart-button">
          <button id="updateCartBtn">Update</button>
        </div>
      </div>

      <script>
        // Retrieve the selected option from local storage
        const selectedOption = localStorage.getItem("selectedOption");
        // Update the <h3> element with the retrieved option
        document.getElementById("selectedOption").innerText = selectedOption;
        // Clear the selected option from local storage (optional)
        localStorage.removeItem("selectedOption");
      </script>
      
      <script src="scripts/kiosk.js"></script>
      <script src="scripts/fetchProductData.js"></script>
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
      ></script>
    </body>
  </html>
