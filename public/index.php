<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

define('BASE_URL', 'http://localhost/product_mvc/');

require_once __DIR__ . '/../app/config/database.php';

// spl_autoload ត្រូវ register មុន require routes
spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// web.php គ្រប់គ្រង routing ទាំងអស់
require_once __DIR__ . '/../app/routes/web.php';