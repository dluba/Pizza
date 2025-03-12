<?php
namespace App\controllers;

use App\models\Pizza;
use App\models\Size;
use App\models\Sauce;
use App\models\Calculator;

class Controller {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showOrderForm() {
        $pizzas = Pizza::getAll();
        $sizes = Size::getAll();
        $sauces = Sauce::getAll();

        include_once __DIR__ . '/../views/order_view.php';
    }

    public function processOrder() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pizza = Pizza::getById(filter_input(INPUT_POST, 'pizza', FILTER_VALIDATE_INT));
            $size = Size::getById(filter_input(INPUT_POST, 'size', FILTER_VALIDATE_INT));
            $sauce = Sauce::getById(filter_input(INPUT_POST, 'sauce', FILTER_VALIDATE_INT));

            if ($pizza && $size && $sauce) {
                $totalBYN = (new Calculator())->calculateTotal($pizza, $size, $sauce);
                echo json_encode([
                    'pizza' => $pizza->getName(),
                    'size' => $size->getName(),
                    'sauce' => $sauce->getName(),
                    'total_byn' => number_format($totalBYN, 2)
                ]);
            } else {
                echo json_encode(['error' => 'Invalid selection']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request method']);
        }
    }
}
