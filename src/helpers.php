<?php
function view(string $name, array $data = [])
{
    try {
        extract($data);
        require __DIR__ . "/Views/{$name}.php";
    } catch (Exception $e) {
        echo "Путь к файлу: " . __DIR__ . "/Views/{$name}.php";
    }
}


function log_error(string $message)
{
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/logs/error.log', (new DateTime())->format('Y-m-d H:i:s') . "\t" . $message . "\r\n", FILE_APPEND);
}

function asset(string $path): string
{
    // Определяем протокол
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

    // Определяем домен (localhost, example.com и т.д.)
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Убираем ведущий слэш у $path, чтобы не получилось двойного //
    $path = ltrim($path, '/');

    // Склеиваем итоговый URL
    return "{$scheme}://{$host}/assets/{$path}";
}
