<?php
namespace App\interfaces;

interface ISize {
    public function getId(): int;
    public function getName(): string;
    public function getPrice(): float;
    public function getPriceBYN(): float; // Добавлен для BYN
}