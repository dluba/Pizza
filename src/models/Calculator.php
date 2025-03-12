<?php
namespace App\models;

use App\interfaces\ISize;
use App\interfaces\IPizza;
use App\interfaces\ISauce;

class Calculator {

    public function calculateTotal(Pizza $pizza, Size $size, Sauce $sauce): float {
        return $this->$pizza->getPriceBYN() + $this->$size->getPriceBYN() + $this->$sauce->getPriceBYN();
    }
    
}