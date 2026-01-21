<?php
echo "<h2>System-wide Repair Tool</h2>";

$filesToFix = ['index.php', 'model/product.php', 'view/layout/header.php'];

foreach ($filesToFix as $file) {
    echo "<h3>Checking $file...</h3>";
    if (!file_exists($file)) {
        echo "❌ File not found.<br>";
        continue;
    }

    $content = file_get_contents($file);
    if (strpos($content, '<<<<<<<') !== false || strpos($content, '>>>>>>>') !== false) {
        echo "⚠️ Git conflict markers detected! Cleaning up...<br>";

        $lines = explode("\n", $content);
        $newLines = [];
        $skipping = false;

        foreach ($lines as $line) {
            if (strpos($line, '<<<<<<<') !== false) {
                $skipping = true;
                echo "Removing marker start...<br>";
                continue;
            }
            if (strpos($line, '=======') !== false) {
                $skipping = false;
                echo "Removing divider...<br>";
                continue;
            }
            if (strpos($line, '>>>>>>>') !== false) {
                echo "Removing marker end...<br>";
                continue;
            }

            if (!$skipping) {
                $newLines[] = $line;
            }
        }

        $newContent = implode("\n", $newLines);
        if (file_put_contents($file, $newContent)) {
            echo "✅ Successfully restored $file.<br>";
        } else {
            echo "❌ Failed to write to $file.<br>";
        }
    } else {
        echo "✅ No Git conflict markers found in $file.<br>";
    }

    // Specific fixes
    if ($file === 'index.php') {
        $content = file_get_contents($file);
        if (strpos($content, 'new CartController()') !== false) {
            echo "Fixing CartController inside index.php...<br>";
            $newContent = str_replace('new CartController()', 'new CartController($db)', $content);
            file_put_contents($file, $newContent);
        }
    }
}

echo "<br><p>Repair complete. Refresh the site to test.</p>";
?>