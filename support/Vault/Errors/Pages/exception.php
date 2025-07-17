<?php

use Support\Vault\Sanctum\Log;

$shortFile = Log::shortenPath($exception->getFile());
$shortTrace = preg_replace(
    '/\/path\/to\/your\/page\folder/',
    '',
    $exception->getTraceAsString()
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unhandled Exception</title>
    <style>
        body { font-family: sans-serif; background: #fff3cd; color: #856404; padding: 2rem; }
        .container { max-width: 800px; margin: auto; background: #ffeeba; padding: 1.5rem; border-radius: 5px; }
        pre { white-space: pre-wrap; word-wrap: break-word; background: #fff; padding: 1rem; border: 1px solid #ddd; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Exception Thrown</h1>
        <p><strong><?= htmlspecialchars($exception->getMessage()) ?></strong></p>
        <p>In file: <code><?= htmlspecialchars($shortFile) ?></code> at line <?= $exception->getLine() ?></p>
        <h3>Stack trace:</h3>
        <pre><?= htmlspecialchars($shortTrace) ?></pre>
    </div>
</body>
</html>