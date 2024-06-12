<?php
require_once 'conn.php';

// Set header to return JSON
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['items'])) {
    $orderItems = $data['items'];

    if (empty($orderItems)) {
        echo json_encode(['success' => false, 'error' => 'No items in the order.']);
        exit;
    }

    $conn->begin_transaction();

    foreach ($orderItems as $item) {
        $product_id = $item['productId'];
        $product_name = $item['productName'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total_price = $quantity * $price;
        $status = 'pending';

        $stmt = $conn->prepare("INSERT INTO orders (product_id, product_name, quantity, price, total_price, status, order_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
            $conn->rollback();
            $conn->close();
            exit;
        }
        $stmt->bind_param("isddds", $product_id, $product_name, $quantity, $price, $total_price, $status);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
            $conn->rollback();
            $conn->close();
            exit;
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid order data.']);
}
?>
