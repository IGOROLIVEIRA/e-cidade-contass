<?php

namespace Model\Arrecadacao\Pix;

class InstituicaoFinanceiraApiPix
{
    public const CODIGO_INSTITUICAO_FINANCEIRA = 1;
    public int $k175_sequencial;
    public string $k175_nome;

    public function __construct(int $k175_sequencial = null)
    {
        if(!empty($k175_sequencial)) {

        }
    }

}
