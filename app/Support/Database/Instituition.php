<?php

namespace App\Support\Database;

trait Instituition
{
    public function getInstituicaoByCnpj(string $cnpj = NULL): array
    {
        if (empty($cnpj)) {
            return [];
        }
        return $this->fetchRow("select codigo from db_config where cgc = '{$cnpj}'");
    }
}
