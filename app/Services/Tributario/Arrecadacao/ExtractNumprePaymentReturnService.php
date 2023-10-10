<?php

namespace App\Services\Tributario\Arrecadacao;

class ExtractNumprePaymentReturnService
{
    public const NUMPRE_POSITION = 37;
    public function execute(string $line): string
    {
        return str_pad((int) substr($line, self::NUMPRE_POSITION, 8), 8, '0', STR_PAD_LEFT);
    }
}
