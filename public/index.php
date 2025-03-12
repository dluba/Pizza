<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\Controller;

$pdo = require_once __DIR__ . '/../config/Database.php';
$controller = new Controller($pdo);
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'order') {
    $controller->processOrder($_GET['pizza'], $_GET['size'], $_GET['sauce']);
} else {
    $controller->showOrderForm();
}
?>
