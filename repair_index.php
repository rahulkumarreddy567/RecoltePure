<?php
$file = 'index.php';
$content = file_get_contents($file);

echo "<h2>Index.php Repair Tool</h2>";

if (strpos($content, '<<<<<<<') !== false || strpos($content, '>>>>>>>') !== false) {
    echo "⚠️ Git conflict markers detected! Attempting to clean up...<br>";

    // Simple regex to remove conflict markers and keep the incoming changes (usually what we want)
    // This is risky but since index.php is small, we can try to find the specific broken area.

    $lines = explode("\n", $content);
    $newLines = [];
    $skipping = false;

    foreach ($lines as $line) {
        if (strpos($line, '<<<<<<<') !== false) {
            $skipping = true;
            echo "Removing: $line<br>";
            continue;
        }
        if (strpos($line, '=======') !== false) {
            $skipping = false;
            echo "Removing marker line...<br>";
            continue;
        }
        if (strpos($line, '>>>>>>>') !== false) {
            echo "Removing: $line<br>";
            continue;
        }

        if (!$skipping) {
            $newLines[] = $line;
        }
    }

    $newContent = implode("\n", $newLines);
    if (file_put_contents($file, $newContent)) {
        echo "✅ Successfully cleaned up conflict markers in index.php.<br>";
    } else {
        echo "❌ Failed to write to index.php.<br>";
    }
} else {
    echo "ℹ️ No Git conflict markers ('<<<<<<<') found in index.php.<br>";
}

// Also fix the CartController constructor if missing $db
$content = file_get_contents($file);
if (strpos($content, 'new CartController()') !== false) {
    echo "Fixing CartController constructor missing \$db...<br>";
    $newContent = str_replace('new CartController()', 'new CartController($db)', $content);
    file_put_contents($file, $newContent);
    echo "✅ Fixed CartController constructor.<br>";
}

echo "<br><p>Repair complete. Refresh the site to test.</p>";
?>