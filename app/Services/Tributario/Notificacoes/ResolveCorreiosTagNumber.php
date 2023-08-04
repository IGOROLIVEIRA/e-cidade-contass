<?php

namespace App\Services\Tributario\Notificacoes;

class ResolveCorreiosTagNumber
{
    protected string $tipoPostal = 'BH';
    protected string $paisOrigem = 'BR';

    public function execute(string $tagNumber, string $checkerDigit)
    {
        return "{$this->tipoPostal}{$tagNumber}{$checkerDigit}{$this->paisOrigem}";
    }
}
