<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/db_connection.php';

echo "<h1>Database Setup</h1>";
echo "<p>Connected to database: " . $database . "</p>"; // $database is available from db_connection.php

$sqlFile = 'recoltePure.sql';

if (!file_exists($sqlFile)) {
    die("<p style='color:red'>Error: SQL file '$sqlFile' not found.</p>");
}

$sql = file_get_contents($sqlFile);

// Remove any lingering merge conflict markers or garbage if any (already fixed, but safety first)
// $sql = preg_replace('/^<<<<<<<.*$/m', '', $sql); 
// ... actually I fixed the file, so it should be clean.

echo "<p>Importing SQL dump...</p>";

// Use multi_query to execute the entire script
if ($db->multi_query($sql)) {
    $i = 0;
    do {
        $i++;
        // Store first result set
        if ($result = $db->store_result()) {
            $result->free();
        }
    } while ($db->more_results() && $db->next_result());

    if ($db->error) {
        echo "<p style='color:red'>Error during execution (Query $i): " . $db->error . "</p>";
    } else {
        echo "<h2 style='color:green'>Database Imported Successfully!</h2>";
        echo "<p>Tables created. You can now delete this file and go to <a href='index.php'>Home</a></p>";
    }
} else {
    echo "<p style='color:red'>MySQL Error: " . $db->error . "</p>";
}

$db->close();
?>