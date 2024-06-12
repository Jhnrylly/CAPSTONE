<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
    <div class="dashboard-container">
        <div class="dashboard">
            <div class="tag"><h1>Dashboard</h1></div>
            <div class="dashboard-grid">
                <div class="top-box revenue-daily">
                    <h2>Daily Revenue</h2>
                        <h3>₱ 35,650</h3>
                        <h4></h4>
                </div>
                <div class="top-box orderNo">
                    <h2>Total Orders</h2>
                    <h3>35</h3>
                </div>
                <div class="top-box customersNo">
                    <h2>Daily Customers</h2>
                    <h3>₱ 15,500</h3>
                </div>
                <div class="best-food revenue">
                    <h2>Best Selling Orders</h2>
                    
                </div>
                <div class="sales-graph">
                    <h2>Net Graph</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="users-body">
        <div class="users-container">
            <div class="users-contain">
                <h2>Admin Profile<button id="button-add">Add New User</button></h2>
                <div class="account-container">
                    <div class="account-container-scroll">
                        <table class="account-container-table" id="dataTable" width="95%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Group/Role</th>
                                    <th>EDIT</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-users-button">
        <button id="dashboard-button">Dashboard</button>
        <button id="users-button">Users</button>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const dashboardButton = document.getElementById('dashboard-button');
    const usersButton = document.getElementById('users-button');
    const dashboardContainer = document.querySelector('.dashboard-container');
    const usersBody = document.querySelector('.users-body');

    dashboardButton.addEventListener('click', function () {
        dashboardContainer.style.display = 'block';
        usersBody.style.display = 'none';
        dashboardButton.classList.add('active');
        usersButton.classList.remove('active');
    });

    usersButton.addEventListener('click', function () {
        usersBody.style.display = 'block';
        dashboardContainer.style.display = 'none';
        usersButton.classList.add('active');
        dashboardButton.classList.remove('active');
    });
});

    </script>
</body>
</html>