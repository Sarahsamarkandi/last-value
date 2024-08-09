<?php
// Display all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost"; // Replace with your servername if needed
$username = "root"; // Replace with your username if needed
$password = ""; // Replace with the actual password if needed
$dbname = "button_clicks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the choice from the POST data
$choice = $_POST['choice'];

// Prepare and execute the insert query
$sql_insert = "INSERT INTO clicks (button_name) VALUES (?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("s", $choice);

if ($stmt->execute()) {
    // Prepare and execute the select query to get the latest inserted value
    $sql_select = "SELECT button_name FROM clicks ORDER BY click_time DESC LIMIT 1";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        // Output the latest direction
        $row = $result->fetch_assoc();
        echo "Record inserted successfully. The value saved is: " . htmlspecialchars($row["button_name"]);
    } else {
        echo "No data found.";
    }
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
