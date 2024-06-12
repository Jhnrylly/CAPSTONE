<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
  <link rel="stylesheet" href="./styles/orderCompleted.css">
</head>
<body>
  <div class="container">
    <div class="container-box">
      <div class="logo"><img src="./images/wheelwhite.png" alt=""></a></div>
      <h1 id="order-number">1</h1>
      <h2>Thank you for<br>Ordering!</h2>
      <button id="backIndex">Order Again <img src="./images/right.png" alt=""></button>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const orderNumberElement = document.getElementById('order-number');
      const currentOrderNumber = sessionStorage.getItem('currentOrderNumber');
      console.log("Retrieved order number from sessionStorage:", currentOrderNumber);
      if (orderNumberElement && currentOrderNumber) {
        orderNumberElement.innerText = currentOrderNumber;
      }

      // Event listener for "backIndex" button to redirect to index.php
      const backIndexButton = document.getElementById('backIndex');
      if (backIndexButton) {
        backIndexButton.addEventListener('click', function() {
          window.location.href = 'index.php';
        });
      }
    });
  </script>
</body>
</html>