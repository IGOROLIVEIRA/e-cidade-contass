<?php

class ValidaTipoJulgamento
{
    private const MENORPRECO  = 'Menor Preço';
    private const MAIORPRECO  = 'Maior Preço';
    private const MAIORDESCONTO = 'Maior Desconto';

    /**
     * Transforma campo tipojulgamento em correspondente valido
     *
     * @param string $tipoJulgamento
     * @return integer
     */
    public function execute(string $tipoJulgamento): int
    {
        if ($tipoJulgamento == self::MENORPRECO || $tipoJulgamento == self::MAIORPRECO) {
            return 3;
        }

        return 1;
    }
}
