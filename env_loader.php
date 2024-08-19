<?php

function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception("The .env file does not exist.");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parse environment variables
        list($name, $value) = explode('=', $line, 2);

        // Remove surrounding quotes if necessary
        $value = trim($value);
        $value = trim($value, '"\'');

        // Set environment variables
        $_ENV[$name] = $value;
        putenv("$name=$value");
    }
}
