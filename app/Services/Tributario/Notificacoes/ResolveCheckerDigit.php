<?php

namespace App\Services\Tributario\Notificacoes;

class ResolveCheckerDigit
{
    public const WEIGHT = [8, 6, 4, 2, 3, 5, 9, 7];

    public function execute(string $tagNumber): int
    {
        if (strpos($tagNumber, '-')) {
            $tagNumber = substr($tagNumber, 0, 7);
        }
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ($tagNumber[$i] * self::WEIGHT[$i]);
        }

        $module = $sum % 11;
        if ($module == 0) {
            return 5;
        }

        if ($module == 1) {
            return 0;
        }

        return 11 - $module;
    }
}