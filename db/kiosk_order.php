<?php
include_once 'conn.php';

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Function to handle the order submission and payment initiation
function handleOrderSubmission() {
    global $conn;

    // Set header to return JSON
    header('Content-Type: application/json');

    // Read the JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'error' => 'Invalid JSON input: ' . json_last_error_msg()]);
        error_log('JSON decode error: ' . json_last_error_msg());
        exit;
    }

    // Check if data contains items
    if (!isset($data['items'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid order data.']);
        error_log('Invalid order data: ' . print_r($data, true));
        exit;
    }

    $orderItems = $data['items'];

    if (empty($orderItems)) {
        echo json_encode(['success' => false, 'error' => 'No items in the order.']);
        exit;
    }

    // Prepare payment details
    $total_amount = array_reduce($orderItems, function($sum, $item) {
        return $sum + ($item['price'] * $item['quantity']);
    }, 0);

    $order_ref = uniqid();

    $orderDetails = [
        'totalAmount' => [
            'value' => $total_amount,
            'currency' => 'PHP'
        ],
        'buyer' => [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '09171234567'
        ],
        'items' => array_map(function($item) {
            return [
                'name' => $item['productName'],
                'quantity' => $item['quantity'],
                'totalAmount' => [
                    'value' => $item['price'] * $item['quantity'],
                    'currency' => 'PHP'
                ],
                'amount' => [
                    'value' => $item['price'],
                    'currency' => 'PHP'
                ]
            ];
        }, $orderItems),
        'requestReferenceNumber' => $order_ref,
        'redirectUrl' => [
            'success' => 'https://yourwebsite.com/handle_payment.php?status=success',
            'failure' => 'https://yourwebsite.com/handle_payment.php?status=failure',
            'cancel' => 'https://yourwebsite.com/handle_payment.php?status=cancel'
        ]
    ];

    // Initiate payment
    $apiKey = 'sk-X8qolYjy62kIzEbr0QRK1h4b4KDVHaNcwMYk39jInSl'; // Replace with your sandbox API key
    $url = 'https://pg-sandbox.paymaya.com/checkout/v1/checkouts';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($apiKey . ':')
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderDetails));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpcode === 200) {
        $responseData = json_decode($response, true);
        
        // Insert order details into the database after successful payment initiation
        $conn->begin_transaction();

        foreach ($orderItems as $item) {
            $product_id = $item['productId'];
            $product_name = $item['productName'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $total_price = $quantity * $price;
            $status = 'pending';

            $stmt = $conn->prepare("INSERT INTO orders (order_ref, product_id, product_name, quantity, price, total_price, status, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            if (!$stmt) {
                echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
                error_log('Prepare failed: ' . $conn->error);
                $conn->rollback();
                $conn->close();
                exit;
            }
            $stmt->bind_param("ssssdds", $order_ref, $product_id, $product_name, $quantity, $price, $total_price, $status);
            if (!$stmt->execute()) {
                echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
                error_log('Execute failed: ' . $stmt->error);
                $conn->rollback();
                $conn->close();
                exit;
            }
        }

        $conn->commit();
        echo json_encode(['success' => true, 'redirectUrl' => $responseData['redirectUrl']]);
    } else {
        $error = curl_error($ch);
        echo json_encode(['success' => false, 'error' => 'Failed to initiate payment. ' . $error]);
        error_log('Curl error: ' . $error);
    }

    curl_close($ch);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleOrderSubmission();
    exit;
}
?>
