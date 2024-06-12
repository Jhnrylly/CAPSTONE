document.addEventListener('DOMContentLoaded', function() {
  let cart = [];

  function addToCart(item) {
    item.quantity = parseInt(item.quantity, 10);
    if (isNaN(item.quantity) || item.quantity <= 0) {
      console.error('Invalid quantity:', item.quantity);
      return;
    }

    const existingItemIndex = cart.findIndex(cartItem => cartItem.id === item.id && cartItem.size === item.size && cartItem.sugar === item.sugar);

    if (existingItemIndex > -1) {
      cart[existingItemIndex].quantity += item.quantity;
    } else {
      cart.push(item);
    }

    updateCartDisplay();
    saveCartToDatabase(item, 'add');
  }

  function saveCartToDatabase(item, action) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        const response = JSON.parse(xhr.responseText);
        if (response.status !== 'success') {
          console.error('Error:', response.message);
        }
      } else {
        console.error('Error saving cart data:', xhr.statusText);
      }
    };
    xhr.onerror = function () {
      console.error('Network error');
    };
    const data = `action=${action}&id=${item.id}&quantity=${item.quantity}&size=${item.size}&sugar=${item.sugar}`;
    xhr.send(data);
  }

  function updateCartDisplay() {
    const cartContainer = document.querySelector('.my-order-list');
    if (!cartContainer) {
      console.error('Cart container not found');
      return;
    }

    cartContainer.innerHTML = '';

    cart.forEach(item => {
      const sugarDisplay = item.sugar !== null ? `<span>${item.sugar}% Sugar,</span>` : '';
      const sizeDisplay = item.size !== null ? `<span>${item.size}</span>` : '';
      let noteDisplay = '';

      const sizeOrder = document.getElementById('size-order');
      const calculator = document.getElementById('calculator');

      if (sizeOrder && calculator) {
        noteDisplay = `<h4>Note: ${sugarDisplay} ${sizeDisplay}</h4>`;
      } else if (sizeOrder) {
        noteDisplay = sizeDisplay ? `<h4>Note: ${sizeDisplay}</h4>` : '';
      } else if (calculator) {
        noteDisplay = sugarDisplay ? `<h4>Note: ${sugarDisplay}</h4>` : '';
      }

      // Check if the data-item-id is between 1 and 19 and hide the noteDisplay
      if (item.id >= 1 && item.id <= 19) {
        noteDisplay = ''; // Hide noteDisplay
      } else if (item.id >= 35 && item.id <= 38) {
        noteDisplay = sizeDisplay ? `<h4>Note: ${sizeDisplay}</h4>` : '';
      } else if (item.id >= 39 && item.id <= 45 || item.id >= 60 && item.id >= 65) {
        noteDisplay = sugarDisplay ? `<h4>Note: ${sugarDisplay}</h4>` : '';
      }

      let itemPrice = item.price;
      if (item.size === "Large") {
        itemPrice += 0;
      }

      const cartItemHTML = `
        <div class="my-order-item" id="item-${item.id}-${item.size}-${item.sugar}" data-item-id="${item.id}" data-item-size="${item.size}" data-item-sugar="${item.sugar}">
          <div class="my-order-grid ${getGridId(item.category)}">
            <div class="my-order-img"><img src="${item.image}" alt="${item.name}"></div>
            <div class="order-food-description">
              <h3>${item.name}</h3>
              ${noteDisplay}
              <h5>₱ ${itemPrice.toFixed(2)} x <span>${item.quantity}</span></h5>
            </div>
            <div class="my-order-food-total">
              <button id="remove-${item.id}-${item.size}-${item.sugar}" class="remove-btn"><img src="./images/cart-cross.png" alt="Remove"></button><br>
              <div class="food-total"><h5>₱ ${(itemPrice * item.quantity).toFixed(2)}</h5></div>
            </div>
          </div>
        </div>
        <hr>
      `;
      cartContainer.innerHTML += cartItemHTML;
    });

    cart.forEach(item => {
      const removeBtn = document.getElementById(`remove-${item.id}-${item.size}-${item.sugar}`);
      if (removeBtn) {
        removeBtn.addEventListener('click', (event) => {
          event.stopPropagation();
          removeFromCart(item);
        });
      }
    });

    cart.forEach(item => {
      const cartItem = document.getElementById(`item-${item.id}-${item.size}-${item.sugar}`);
      if (cartItem) {
        cartItem.addEventListener('click', () => {
          showPopupCart(item);
        });
      }
    });

    updateTotalPrice();
  }

  function removeFromCart(item) {
    cart = cart.filter(cartItem => !(cartItem.id === item.id && cartItem.size === item.size && cartItem.sugar === item.sugar));
    updateCartDisplay();
    saveCartToDatabase(item, 'remove');
  }

  function updateTotalPrice() {
    const totalPrice = cart.reduce((sum, item) => {
      let itemPrice = item.price;
      if (item.size === "Large") {
        itemPrice += 0;
      }
      return sum + (itemPrice * item.quantity);
    }, 0);
    const totalElement = document.querySelector('.my-order-total-container .totalProduct');
    if (totalElement) {
      totalElement.innerText = `₱ ${totalPrice.toFixed(2)}`;
    } else {
      console.error('Total price element not found');
    }
  }

  function createProductHTML(product) {
    return `
    <div class="order-container" data-product-id="${product.id}">
        <div class="order-image-container">
            <img class="order-image" src="${product.image}" alt="${product.name}" />
        </div>
        <div class="order-name limit-text-to-2-lines">
            <h4>${product.name}</h4>
        </div>
        <div class="order-price">₱ ${product.pricePeso}</div>
    </div>`;
  }

  function createProductElements(productData) {
    try {
      const products = JSON.parse(productData);
      products.forEach(product => {
        const productHTML = createProductHTML(product);
        const gridId = getGridId(product.category);
        const grid = document.querySelector(`#${gridId}`);
        if (grid && productHTML && gridId) {
          const card = document.createElement('div');
          card.classList.add('card');
          card.classList.add(gridId); // Adding the category as a class
          card.innerHTML = productHTML;
          card.addEventListener('click', () => displayProduct(product));
          grid.appendChild(card);
        } else {
          console.error("Error: Unable to append product to grid.");
        }
      });
    } catch (error) {
      console.error("Error parsing product data:", error);
    }
  }

  function getGridId(category) {
    const categories = {
      "silog": "silog",
      "snacks": "snacks",
      "beverages": "beverages",
      "milktea": "milktea",
      "fruit": "fruit",
      "frappucino": "frappucino",
      "mango": "mango",
      "latte": "latte",
      "milkshake": "milkshake",
      "creamy": "creamy",
      "americano": "americano"
    };
    return categories[category] || "";
  }

  function fetchProductData() {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', './db/fetchproduct.php', true);
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          resolve(xhr.responseText);
        } else {
          reject('Error fetching product data: ' + xhr.statusText);
        }
      };
      xhr.onerror = function () {
        reject('Error fetching product data: Network error');
      };
      xhr.send();
    });
  }

  fetchProductData()
    .then(createProductElements)
    .catch(error => console.error(error));

  const closeButton = document.getElementById('closePopup');
  if (closeButton) {
    closeButton.addEventListener('click', () => {
      const popup = document.getElementById('myPopup');
      popup.style.display = 'none';
      document.getElementById('quantity').value = 1;
    });
  }

  window.addEventListener('click', (event) => {
    const popup = document.getElementById('myPopup');
    if (event.target === popup) {
      popup.style.display = 'none';
      document.getElementById('quantity').value = 1;
    }
  });

  const decreaseButton = document.querySelector('.decrease');
  const increaseButton = document.querySelector('.increase');
  const quantityInput = document.getElementById('quantity');

  if (decreaseButton && increaseButton && quantityInput) {
    decreaseButton.addEventListener('click', () => {
      let currentQuantity = parseInt(quantityInput.value, 10);
      if (currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
      }
    });

    increaseButton.addEventListener('click', () => {
      let currentQuantity = parseInt(quantityInput.value, 10);
      quantityInput.value = currentQuantity + 1;
    });

    quantityInput.addEventListener('input', () => {
      let currentQuantity = parseInt(quantityInput.value, 10);
      if (isNaN(currentQuantity) || currentQuantity <= 0) {
        quantityInput.value = 1;
      }
    });
  }

  function getProductData() {
    const productNameElement = document.querySelector(".popup-content h4");
    const productImageElement = document.querySelector(".popup-content img");
    const productPriceElement = document.querySelector(".popup-box .order-price");
    const productIdElement = document.querySelector(".popup-content [data-product-id]");
    const sugarLevelElement = document.querySelector("#sugarPercentage");
    const sizeElement = document.querySelector("#size-order input[type='radio']:checked");

    const productName = productNameElement ? productNameElement.innerText : "";
    const productImage = productImageElement ? productImageElement.getAttribute("src") : "";
    const productPriceText = productPriceElement ? productPriceElement.textContent.trim().replace('₱', '') : "0";
    const productPrice = parseFloat(productPriceText);
    const productId = productIdElement ? productIdElement.getAttribute('data-product-id') : "";
    const quantity = parseInt(document.getElementById('quantity').value, 10);

    if (isNaN(quantity) || quantity <= 0) {
      console.error('Invalid quantity in getProductData:', quantity);
      return null;
    }

    const sugarLevel = sugarLevelElement && sugarLevelElement.value !== "" ? parseInt(sugarLevelElement.value, 10) : null;
    const size = sizeElement ? sizeElement.nextElementSibling.innerText.trim() : null;

    let finalPrice = productPrice;
    if (size === "Large") {
      finalPrice += 10;
    }

    const product = {
      id: productId,
      name: productName,
      image: productImage,
      price: finalPrice,
      quantity: quantity,
      sugar: sugarLevel,
      size: size
    };

    return product;
  }

  const addToCartBtn = document.getElementById('addToCartBtn');
  if (addToCartBtn) {
    addToCartBtn.addEventListener('click', () => {
      const productData = getProductData();
      if (productData) {
        addToCart(productData);
        document.getElementById('myPopup').style.display = 'none';
      } else {
        console.error('Invalid product data, not adding to cart.');
      }
    });
  } else {
    console.error('Add to Cart button not found');
  }

  function displayProduct(product, isEdit = false) {
    const popupContent = document.querySelector(".popup-content");
    popupContent.innerHTML = createProductHTML(product);

    const popup = document.getElementById("myPopup");
    popup.style.display = "block";

    const categoriesWithCalculator = ["milktea", "americano", "milkshake", "mango", "latte", "frappucino", "creamy"];
    const categoriesWithSizeOrder = ["milktea", "americano", "milkshake", "mango", "latte", "fruit"];

    document.getElementById("calculator").style.display = categoriesWithCalculator.includes(product.category) ? "flex" : "none";
    document.getElementById("size-order").style.display = categoriesWithSizeOrder.includes(product.category) ? "flex" : "none";

    if (isEdit) {
      document.getElementById('quantity').value = product.quantity;
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const sizeOrder = document.getElementById('size-order');
    const inputs = sizeOrder.querySelectorAll('input[type="radio"]');
    const labels = sizeOrder.querySelectorAll('.size-label');

    labels.forEach(label => {
      label.addEventListener('click', function() {
        labels.forEach(l => l.classList.remove('selected'));
        this.classList.add('selected');

        const inputId = this.getAttribute('for');
        const input = document.getElementById(inputId);
        input.checked = true;

        labels.forEach(l => l.style.backgroundColor = '');
        this.style.backgroundColor = '#ddd';
      });
    });
  });

  function showPopupCart(item) {
    const popupCart = document.getElementById('myPopupCart');
    if (popupCart) {
      const popupCartImg = popupCart.querySelector('.popup-cart-img img');
      const popupCartQuantity = popupCart.querySelector('#quantity-cart');
      const popupCartName = popupCart.querySelector('.popup-cart-name');

      if (popupCartImg) {
        popupCartImg.src = item.image;
      }

      if (popupCartQuantity) {
        popupCartQuantity.value = item.quantity;
      }

      if (popupCartName) {
        popupCartName.textContent = item.name;
      }

      popupCart.style.display = 'block';

      const popupDecreaseButton = popupCart.querySelector('.decrease');
      const popupIncreaseButton = popupCart.querySelector('.increase');

      popupDecreaseButton.replaceWith(popupDecreaseButton.cloneNode(true));
      popupIncreaseButton.replaceWith(popupIncreaseButton.cloneNode(true));

      const newPopupDecreaseButton = popupCart.querySelector('.decrease');
      const newPopupIncreaseButton = popupCart.querySelector('.increase');

      if (newPopupDecreaseButton && newPopupIncreaseButton && popupCartQuantity) {
        newPopupDecreaseButton.addEventListener('click', () => {
          let currentQuantity = parseInt(popupCartQuantity.value, 10);
          if (currentQuantity > 1) {
            popupCartQuantity.value = currentQuantity - 1;
          }
        });

        newPopupIncreaseButton.addEventListener('click', () => {
          let currentQuantity = parseInt(popupCartQuantity.value, 10);
          popupCartQuantity.value = currentQuantity + 1;
        });

        popupCartQuantity.addEventListener('input', () => {
          let currentQuantity = parseInt(popupCartQuantity.value, 10);
          if (isNaN(currentQuantity) || currentQuantity <= 0) {
            popupCartQuantity.value = 1;
          }
        });
      }

      const updateCartBtn = document.getElementById('updateCartBtn');
      updateCartBtn.replaceWith(updateCartBtn.cloneNode(true));
      const newUpdateCartBtn = document.getElementById('updateCartBtn');
      if (newUpdateCartBtn) {
        newUpdateCartBtn.addEventListener('click', () => {
          const newQuantity = parseInt(popupCartQuantity.value, 10);
          if (!isNaN(newQuantity) && newQuantity > 0) {
            item.quantity = newQuantity;
            updateCartDisplay();
            popupCart.style.display = 'none';
          } else {
            console.error('Invalid quantity:', newQuantity);
          }
        });
      }

    } else {
      console.error('Popup cart element not found');
    }
  }

  const popupCartCloseButton = document.querySelector('.popup-cart .close1');
  if (popupCartCloseButton) {
    popupCartCloseButton.addEventListener('click', () => {
      const popupCart = document.getElementById('myPopupCart');
      if (popupCart) {
        popupCart.style.display = 'none';
      }
    });
  }

  document.querySelectorAll('[data-item-id]').forEach(cartItem => {
    cartItem.addEventListener('click', () => {
      const itemId = cartItem.getAttribute('data-item-id');
      const itemSize = cartItem.getAttribute('data-item-size');
      const itemSugar = cartItem.getAttribute('data-item-sugar');
      const item = cart.find(cartItem => cartItem.id === itemId && cartItem.size === itemSize && cartItem.sugar === itemSugar);
      if (item) {
        showPopupCart(item);
      }
    });
  });


  function generateOrderNumber() {
    let currentOrderNumber = parseInt(sessionStorage.getItem('currentOrderNumber'), 10) || 0;
    currentOrderNumber = (currentOrderNumber % 99) + 1;
    sessionStorage.setItem('currentOrderNumber', currentOrderNumber);
    window.location.href = 'ordercompleted.php';
  }

  // Event listener for the "done-button"
  const doneButton = document.getElementById('done-button');
  if (doneButton) {
    doneButton.addEventListener('click', generateOrderNumber);
  }
});