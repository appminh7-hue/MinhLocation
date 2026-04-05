<?php

// Database configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create tables if they do not exist
function createTables($conn) {
    // Create table for storing short links
    $sqlShortLinks = "CREATE TABLE IF NOT EXISTS short_links (\
        id INT AUTO_INCREMENT PRIMARY KEY, \
        short_link VARCHAR(255) NOT NULL UNIQUE, \
        original_url TEXT NOT NULL, \
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\
    );";

    // Create table for storing access logs
    $sqlAccessLogs = "CREATE TABLE IF NOT EXISTS access_logs (\
        id INT AUTO_INCREMENT PRIMARY KEY, \
        short_link_id INT NOT NULL, \
        ip_address VARCHAR(45) NOT NULL, \
        access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, \
        FOREIGN KEY (short_link_id) REFERENCES short_links(id) ON DELETE CASCADE\
    );";

    // Execute the creation of short links table
    if ($conn->query($sqlShortLinks) === TRUE) {
        echo "Short links table created successfully.\n";
    } else {
        echo "Error creating short links table: " . $conn->error . "\n";
    }

    // Execute the creation of access logs table
    if ($conn->query($sqlAccessLogs) === TRUE) {
        echo "Access logs table created successfully.\n";
    } else {
        echo "Error creating access logs table: " . $conn->error . "\n";
    }
}

// Call the function to create tables
createTables($conn);

// Close the connection
$conn->close();

?>