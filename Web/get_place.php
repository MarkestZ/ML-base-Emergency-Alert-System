<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = "maki43499";
$dbname = "eas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch Place data along with Location
$sql = "SELECT Location.Location_Name, Location.Location_where, Place.Place_Stat 
        FROM Place 
        JOIN Location ON Place.Place_Location = Location.Location_ID";

$result = $conn->query($sql);

// Output data in JSON format
$places = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }
}
echo json_encode($places);

// Close connection
$conn->close();
