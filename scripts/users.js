

document.addEventListener('DOMContentLoaded', function () {
  function fetchUserData() {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', './db/fetchusers.php', true); // Adjust the URL to match your PHP script for fetching user data
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          resolve(JSON.parse(xhr.responseText));
        } else {
          reject('Error fetching user data: ' + xhr.statusText);
        }
      };
      xhr.onerror = function () {
        reject('Error fetching user data: Network error');
      };
      xhr.send();
    });
  }
  
  
  function populateUserData() {
    const tableBody = document.getElementById('userTableBody');
  
    fetchUserData()
        .then(userData => {
            // Create an array to store user elements
            const userElements = userData.map(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.user_id}</td>
                    <td>${user.username}</td>
                    <td>${user.password}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td><button>EDIT</button></td>
                    <td><button>DELETE</button></td>
                `;
                return row;
            });
  
            // Append all user elements to the table body
            userElements.forEach(userElement => {
                tableBody.appendChild(userElement);
            });
        })
        .catch(error => {
            console.error(error);
        });
  }
  populateUserData();
});