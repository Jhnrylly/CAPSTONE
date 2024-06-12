<?php
include_once "conn.php";

// Check if the form data contains the necessary fields
if(isset($_POST['name'], $_POST['price'], $_POST['category'], $_POST['id'])) {
    // Sanitize and validate input data
    $name = htmlspecialchars($_POST['name']);
    $price = floatval($_POST['price']); // Convert to floating-point number
    $category = htmlspecialchars($_POST['category']);
    $id = intval($_POST['id']); // Retrieve the ID parameter

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE products SET name=?, price=?, category=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $name, $price, $category, $id);

    if ($stmt->execute()) {
        // Return JSON response for success
        echo json_encode(array("status" => "success", "message" => "Record updated successfully"));
    } else {
        // Return JSON response for error
        echo json_encode(array("status" => "error", "message" => "Error updating record: " . $stmt->error));
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Return JSON response for missing parameters
    echo json_encode(array("status" => "error", "message" => "Error: Missing parameters"));
}
?>
