<?php
// redirect.php

// Function to handle short link redirects and track IP addresses
function redirectTo($shortCode) {
    // Database or logic to determine the URL from the short code
    $url = getUrlFromShortCode($shortCode);

    if ($url) {
        // Track IP address
        trackIP($_SERVER['REMOTE_ADDR']);

        // Redirect to the original URL
        header('Location: ' . $url);
        exit;
    } else {
        // Handle short code not found
        http_response_code(404);
        echo 'Not Found';
    }
}

// Placeholder function to simulate URL retrieval from database
function getUrlFromShortCode($shortCode) {
    // Replace this with actual database lookup logic
    $links = [
        'abc' => 'https://example.com/page1',
        'def' => 'https://example.com/page2',
    ];
    return $links[$shortCode] ?? null;
}

// Placeholder function to track IP addresses
function trackIP($ip) {
    // Implement your tracking logic here (e.g., save to a database or a log file)
    error_log('Tracked IP: ' . $ip);
}

// Assuming the short code is passed as a query parameter
if (isset($_GET['code'])) {
    redirectTo($_GET['code']);
} else {
    http_response_code(400);
    echo 'Bad Request';
}