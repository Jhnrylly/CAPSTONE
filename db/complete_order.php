<?php
require_once 'conn.php';

// Set header to return JSON
header('Content-Type: application/json');

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['orderId'])) {
    $orderId = $data['orderId'];
    $status = 'completed';

    // Start a transaction
    $conn->begin_transaction();

    // Get the order details from the orders table
    $stmt = $conn->prepare("SELECT product_name, quantity, price, total_price, order_date FROM orders WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
        $conn->rollback();
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $orderId);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
        $conn->rollback();
        $conn->close();
        exit;
    }
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if ($order) {
        // Insert the order details into the order_history table
        $stmt = $conn->prepare("INSERT INTO order_history (product_name, quantity, price, total_price, status, order_date) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
            $conn->rollback();
            $conn->close();
            exit;
        }
        $stmt->bind_param("sddsss", $order['product_name'], $order['quantity'], $order['price'], $order['total_price'], $status, $order['order_date']);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
            $conn->rollback();
            $conn->close();
            exit;
        }
        $stmt->close();

        // Delete the order from the orders table
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
            $conn->rollback();
            $conn->close();
            exit;
        }
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
            $conn->rollback();
            $conn->close();
            exit;
        }
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Order not found']);
        $conn->rollback();
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid order data.']);
}
?>
p