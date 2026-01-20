<?php
require_once 'config/db_connection.php';

echo "<h1>Applying Database Schema Fixes</h1>";

// Function to safely run a query
function runQuery($db, $sql, $description)
{
    echo "<p>$description ... ";
    try {
        if ($db->query($sql)) {
            echo "<span style='color:green'>SUCCESS</span></p>";
        } else {
            // Ignore "Duplicate column" or similar harmless errors if possible, otherwise print
            echo "<span style='color:orange'>Info: " . $db->error . "</span></p>";
        }
    } catch (Exception $e) {
        echo "<span style='color:red'>Exception: " . $e->getMessage() . "</span></p>";
    }
}

// 1. Fix Users Table
runQuery($db, "ALTER TABLE users MODIFY customer_id INT(11) NOT NULL AUTO_INCREMENT", "Fixing customer_id AUTO_INCREMENT");
runQuery($db, "ALTER TABLE users MODIFY phone_number INT(10) NULL DEFAULT NULL", "Fixing phone_number NULLABLE");

// 2. Add Missing Payment Columns to order_or_cart
// We check if the column exists first to avoid SQL syntax errors on older MySQL versions that don't support 'IF NOT EXISTS'
$columnsToAdd = [
    'payment_status' => "VARCHAR(50) DEFAULT 'Pending'",
    'payment_method' => "VARCHAR(50) DEFAULT NULL",
    'transaction_id' => "VARCHAR(255) DEFAULT NULL",
    'payment_date' => "DATETIME DEFAULT NULL",
    'amount_paid' => "DECIMAL(10,2) DEFAULT 0.00"
];

foreach ($columnsToAdd as $col => $def) {
    echo "<p>Checking column <code>$col</code> ... ";
    $checkResult = $db->query("SHOW COLUMNS FROM order_or_cart LIKE '$col'");

    if ($checkResult && $checkResult->num_rows > 0) {
        echo "<span style='color:blue'>Already Exists</span></p>";
    } else {
        $sql = "ALTER TABLE order_or_cart ADD COLUMN $col $def";
        runQuery($db, $sql, "Adding column $col");
    }
}

echo "<h3>Done. Try registering and ordering again.</h3>";
?>