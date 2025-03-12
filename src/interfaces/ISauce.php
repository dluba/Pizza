<?php
namespace App\interfaces;

interface ISauce {
    public function getId(): int;
    public function getName(): string;
    public function getPrice(): float;
    public function getPriceBYN(): float; // Добавлен для BYN
}