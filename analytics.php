<?php

// analytics.php

// Display short link statistics and click analytics

// Simulated data for illustration purposes
$shortLinks = [
    ['url' => 'http://example.com/abc', 'clicks' => 120, 'created_at' => '2026-04-01 12:00:00'],
    ['url' => 'http://example.com/def', 'clicks' => 85, 'created_at' => '2026-04-02 12:00:00'],
    ['url' => 'http://example.com/ghi', 'clicks' => 45, 'created_at' => '2026-04-03 12:00:00'],
];

// Display the analytics
echo "<h1>Short Link Statistics</h1>";

foreach ($shortLinks as $link) {
    echo "<p>URL: <a href='" . $link['url'] . "'>" . $link['url'] . "</a><br>Clicks: " . $link['clicks'] . "<br>Created At: " . $link['created_at'] . "</p>";
}

?>