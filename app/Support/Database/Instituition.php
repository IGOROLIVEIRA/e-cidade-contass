<?php

namespace App\Support\Database;

trait Instituition
{
    public function getInstituicaoByCnpj(string $cnpj = NULL): ?string
    {
        if (empty($cnpj)) {
            return null;
        }
        return $this->fetchRow("select codigo from db_config where cgc = '{$cnpj}'");
    }
}
