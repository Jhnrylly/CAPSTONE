<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./styles/cashier.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <title>Document</title>
</head>
<body>
    <div class="body-container">
        <div class="left-container">
            <div class="process-button-container">
            <button type="button" class="btn btn-outline-warning active" data-bs-toggle="button" aria-pressed="true">On-process</button>
            <button type="button" class="btn btn-outline-success" data-bs-toggle="button" aria-pressed="true">Completed</button>
            </div>

            <div class="ongoing-orders-list-container">
                <div class="ongoing-orders-list-grid">
                    <div class="ongoing-orders-items"> <!---To duplicate the orders--->
                        <div class="ongoing-orders-list">
                            <div class="ongoing-order-number"><h2>Orders: # <span id="orderNumberDisplay"></span></h2></div>
                            <div class="ongoing-order-time"><h4>20:30pm</h4></div>
                            <div class="ongoing-order-quantity"><h5>Qta: <span id="ongoingNumberDisplay">5</span></h5></div>
                            <div class="ongoing-order-cost">
                                <h5>₱157,200</h5>
                                <div class="ongoing-order-process">Dine in</div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="right-container">
            <div class="right-border-container">
                <div class="right-border-display">
                    <div class="order-description" >
                        <h3>Orders ID</h3>
                        <div class="right-order-number"><h4>#23</h4></div>
                        <div class="void-button"><button>Void</button></div>
                        <div class="discount-button" id="discountButton"><button>Discount</button></div>
                    </div>
                    <div class="order-food-list-grid">
                        <div class="ongoing-food"> <!---To duplicate the orders--->
                            <div class="ongoing-food-grid">
                                <div class="ongoing-img"><img src="./images/choco.png"></div>
                                <div class="ongoing-food-description">
                                    <h3 id="name">Choco - Milktea</h3>
                                    <h4>Note:<span id="sugar"> 50% sugar</span> ,<span id=""size>Large</span></h4>
                                    <h5 id="price">₱60 <span  id="quantity">x4</span></h5>
                                </div>
                                <div class="ongoing-food-total">
                                    <button id="remove"><img src="./images/cart-cross.png"></button><br>
                                    <div class="food-total"><h5>₱240</h5></div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="total-payment-container">
                    <div class="payment-total-items">
                        <h3>Items(5) <span id="total-items-cost">₱240</span></h3>
                        <h5>Discount: <span id="total-discount">₱240</span></h5>
                    </div>
                    <div class="total-payment">
                        <button id="payButton">Pay</button>
                        <h2 id="total-order">Total: ₱240</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ORDER-UPDATE -->
    <div class="popup-box" id="mypopup">
        <span class="close" id="closePopup">&times;</span>
        <div class="popup-content">
            <div class="popup-img"><img src="./images/choco.png"></div>
            <h2 id="name">Choco-Milktea</h2>
            <h3 id="popup-cost">₱24</h3>
            <div class="size-order" id="size-order" style="display: none">
                <input type="radio" name="size" id="medium" value="MEDIUM">
                <label for="medium">MEDIUM</label>
                <input type="radio" name="size" id="large" value="LARGE">
                <label for="large"> LARGE: +10 PHP</label>
            </div>
            <div id="calculator" style="display:none">
                <label for="sugarPercentage">Sugar Percentage:</label>
                <select id="sugarPercentage">
                    <option value="0.25">25%</option>
                    <option value="0.5">50%</option>
                    <option value="0.75">75%</option>
                    <option value="1">100%</option>
                </select>
            </div>
            <div class="quantity-control">
                <button class="decrease">-</button>
                <input type="number" id="quantity" value="1" min="1" />
                <button class="increase">+</button>
            </div>
        <button id="update-confirm">Update</button>
        </div>
    </div>

    <!-- DISCOUNT UPDATE -->
    <div class="popup-discount-box" id="discountPopup">
    <span class="close" id="closePopup">&times;</span>
        <div class="popup-discount-box-content">
            <div class="discount-img"><img src="./images/choco.png"></div>
            <h2 id="popup-name">Choco - Milktea</h2>
            <div class="quantity-control">
                <button class="decrease">-</button>
                <input type="number" id="quantity" value="1" min="1" />
                <button class="increase">+</button>
            </div>
            <label class="checkbox-discount">
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>

    <!-- PAYMENT UPDATE -->
    <div class="popup-pay-box" id="payPopup">
        <div class="popup-pay-box-content">
            <h2 id="queue">Order: #32 <span class="close">&times;</span></h2>
        </div>
        <div class="popup-total">
            <h3>Subtotal: <span id="subtotal-items-cost">₱240</span></h3>
            <h3>Discount: <span id="discount-items-cost">₱240</span></h3>
        </div>

        <div class="popup-pay-change">
            <label for="fname">Payment:</label>
            <input type="number" id="fname" name="fname" attribute=""> <br>
            <h3>Total: <span id="total-items-cost">₱240</span></h3>
            <h4>Change: <span id="change-items-cost">₱240</span></h4>
        </div>

        <div class="pay-button">
            <button id="pay-button">mark as paid</button>
        </div>
    </div>

    <script>
    // Get the modal
    var modal1 = document.getElementById("mypopup");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var btn = document.getElementById("#");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[1];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal1.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal1.style.display = "none"; 
    }
</script>

    <script>
    // Get the modal
    var modal1 = document.getElementById("discountPopup");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var btn = document.getElementById("discountButton");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[1];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal1.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal1.style.display = "none"; 
    }
</script>

<script>
    // Get the modal
    var modal = document.getElementById("payPopup");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var btn = document.getElementById("payButton");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[2];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none"; 
    }    
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const rightBorderDisplay = document.querySelector('.right-border-display');
    const totalPayment = document.querySelector('.total-payment-container');

    // Function to check the display property and update the class
    function updateTotalPaymentClass() {
      if (window.getComputedStyle(rightBorderDisplay).display === 'none') {
        totalPayment.classList.add('no-border');
      } else {
        totalPayment.classList.remove('no-border');
      }
    }

    // Initial check
    updateTotalPaymentClass();

    // Optional: if the display property of .right-border-display might change dynamically
    const observer = new MutationObserver(updateTotalPaymentClass);
    observer.observe(rightBorderDisplay, { attributes: true, attributeFilter: ['style', 'class'] });

    // Clean up observer when not needed
    // observer.disconnect();
    
  });
</script>

<script src="scripts/cashier.js"></script>
<script src="scripts/fetchProductData.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>