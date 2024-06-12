<?php
require_once 'conn.php';

// Set header to return JSON
header('Content-Type: application/json');

// Fetch orders from the database
$sql = "SELECT id, product_id, product_name, quantity, price, total_price, status, order_date FROM orders";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode(['success' => true, 'orders' => $orders]);

$conn->close();
?>
