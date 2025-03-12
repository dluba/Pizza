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
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Invalid request method');
            }

            $pizzaId = filter_input(INPUT_POST, 'pizza', FILTER_VALIDATE_INT);
            $sizeId = filter_input(INPUT_POST, 'size', FILTER_VALIDATE_INT);
            $sauceId = filter_input(INPUT_POST, 'sauce', FILTER_VALIDATE_INT);

            if (!$pizzaId || !$sizeId || !$sauceId) {
                throw new \Exception('Invalid input data');
            }

            $pizza = Pizza::getById($pizzaId);
            $size = Size::getById($sizeId);
            $sauce = Sauce::getById($sauceId);

            if (!$pizza || !$size || !$sauce) {
                throw new \Exception('Invalid selection');
            }

            $calculator = new Calculator();
            $totalBYN = $calculator->calculateTotal($pizza, $size, $sauce);

            $response = [
                'pizza' => $pizza->getName(),
                'size' => $size->getName(),
                'sauce' => $sauce->getName(),
                'total_byn' => number_format($totalBYN, 2)
            ];

            echo json_encode($response);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}