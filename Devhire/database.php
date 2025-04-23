<?php
// database.php
$config = require __DIR__ . '/config.php';
try {
    $db = new PDO('sqlite:' . $config['db_path']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Connection failed: ' . $e->getMessage());
}
