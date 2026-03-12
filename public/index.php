<?php
session_start();

// Define base URL (adjust if needed)
define('BASE_URL', 'http://localhost/product_mvc/');

require_once '../app/config/database.php';
require_once '../app/routes/web.php';