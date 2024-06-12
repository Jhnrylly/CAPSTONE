<?php
include_once "conn.php"; 

// Fetch product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = array();
    // Fetch product data and store it in an array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    // Output the products array as JSON
    echo json_encode($products);
} else {
    echo json_encode(array("message" => "No products found"));
}



// Create operation
if(isset($_POST['create'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, price) VALUES ('$name', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}