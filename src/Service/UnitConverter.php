<?php

namespace App\Service;

class UnitConverter
{
    public function convertToGrams(int $quantity, string $unit): int
    {
        return match (strtolower($unit)) {
            'kg' => $quantity * 1000,
            'g' => $quantity,
            default => throw new \InvalidArgumentException("Invalid unit: $unit"),
        };
    }}
