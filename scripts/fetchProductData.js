// Function to fetch product data from the PHP script using AJAX
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
