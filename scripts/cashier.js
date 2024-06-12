document.addEventListener('DOMContentLoaded', function() {
    function displayOrderNumber() {
      const orderNumberDisplay = document.getElementById('orderNumberDisplay');
      const currentOrderNumber = sessionStorage.getItem('currentOrderNumber');
      if (orderNumberDisplay && currentOrderNumber) {
        orderNumberDisplay.textContent = `#${currentOrderNumber}`;
      } else {
        console.error('Order number display element not found or no order number in sessionStorage');
      }
    }
  
    displayOrderNumber();
  });