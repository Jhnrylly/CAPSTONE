<?php
include_once "conn.php"; 

// Fetch user data from the database
$sql = "SELECT user_id, username, password, email, role FROM superusers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $superusers = array();
    // Fetch user data and store it in an array
    while ($row = $result->fetch_assoc()) {
        $superusers[] = $row;
    }
    // Output the superusers array as JSON
    echo json_encode($superusers);
} else {
    echo json_encode(array("message" => "No superusers found"));
}
?>
