<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <title>HOME PAGE</title>
    <style>
      .box {
        cursor: pointer;
      }
      .active {
        border: 2px solid blue; 
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="box-container">
        <div class="logo">
          <img src="./images/Logo.png" alt="Rastea house logo" />
        </div>
        <div class="box-border">
          <div class="box pick-order" id="Dine">
            <div class="box-corner">
              <img src="./images/dineIn.png" alt="" />
            </div>
            <p>DINE IN</p>
          </div>
          <div class="box pick-order" id="Out">
            <div class="box-corner">
              <img src="./images/takeOut.png" alt="" />
            </div>
            <p>TAKE OUT</p>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Get references to the boxes
      const dineInBox = document.getElementById("Dine");
      const takeOutBox = document.getElementById("Out");
      const rightText = document.querySelector(".right-text h3");

      // Function to handle clicks
      function handleClick(event) {
        // Remove 'active' from both boxes
        dineInBox.classList.remove("active");
        takeOutBox.classList.remove("active");

        // Add 'active' class to the box that was clicked
        event.currentTarget.classList.add("active");

        // Additional actions for dine-in or take-out selections
        // Example:
        if (event.currentTarget.id === "Dine") {
          console.log("Dine-in selected");
          localStorage.setItem("selectedOption", "Dine in");
          window.location.href = "ordering.php";
        } else if (event.currentTarget.id === "Out") {
          console.log("Take-out selected");
          localStorage.setItem("selectedOption", "Take out");
          window.location.href = "ordering.php";
        }
      }

      // Event listeners
      dineInBox.addEventListener("click", handleClick);
      takeOutBox.addEventListener("click", handleClick);
    </script>
  </body>
</html>
