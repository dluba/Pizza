<?php
namespace App\interfaces;

interface IPizza {
    public function getId(): int;
    public function getName(): string;
    public function getPrice(): float;
    public function getPriceBYN(): float; 
}