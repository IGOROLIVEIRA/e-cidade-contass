<?php

namespace App\Support\Database;

trait Instituition
{
    public function checkInstituicaoExists(string $cnpj): bool
    {
        return !!$this->fetchRow("select codigo from db_config where cgc = '{$cnpj}'");
    }
}
